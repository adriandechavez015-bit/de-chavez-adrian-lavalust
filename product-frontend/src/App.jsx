import React, { useState, useEffect } from 'react';
import axios from 'axios';

const API_BASE_URL = 'https://de-chavez-adrian-lavalust.onrender.com/api';
function App() {
  const [token, setToken] = useState(localStorage.getItem('token') || '');
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [products, setProducts] = useState([]);
  const [form, setForm] = useState({ id: null, product_name: '', description: '', price: '', quantity: '' });

  // Axios instance with token header
  const api = axios.create({
    baseURL: API_BASE_URL,
    headers: { Authorization: `Bearer ${token}` }
  });

  useEffect(() => {
    if (token) {
      fetchProducts();
    }
  }, [token]);

  const handleLogin = async (e) => {
    e.preventDefault();
    try {
      const res = await axios.post(`${API_BASE_URL}/login`, { username, password });
      
      // 1. Save token
      localStorage.setItem('token', res.data.token);
      
      // 2. Force browser reload so it instantly loads the CRUD view
      window.location.reload();
    } catch (err) {
      alert('Login failed. Please check your credentials.');
    }
  };

  const handleLogout = () => {
    localStorage.removeItem('token');
    setToken('');
    setProducts([]);
  };

  const fetchProducts = async () => {
    try {
      const res = await api.get('/products');
      setProducts(res.data);
    } catch (err) {
      if (err.response?.status === 401) handleLogout();
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      if (form.id) {
        await api.put(`/products/${form.id}`, form);
      } else {
        await api.post('/products', form);
      }
      setForm({ id: null, product_name: '', description: '', price: '', quantity: '' });
      fetchProducts();
    } catch (err) {
      alert('Failed to save product');
    }
  };

  const handleEdit = (p) => setForm(p);

  const handleDelete = async (id) => {
    if (window.confirm('Delete this product?')) {
      await api.delete(`/products/${id}`);
      fetchProducts();
    }
  };

  if (!token) {
    return (
      <div style={{ padding: '2rem', maxWidth: '350px', margin: 'auto' }}>
        <h2>Login</h2>
        <form onSubmit={handleLogin}>
          <input 
            type="text" 
            placeholder="Username" 
            value={username} 
            onChange={e => setUsername(e.target.value)} 
            required 
          /><br/><br/>
          <input 
            type="password" 
            placeholder="Password" 
            value={password} 
            onChange={e => setPassword(e.target.value)} 
            required 
          /><br/><br/>
          <button type="submit">Login</button>
        </form>
      </div>
    );
  }

  return (
    <div style={{ padding: '2rem', maxWidth: '750px', margin: 'auto' }}>
      <h2>Product Management System</h2>
      <button onClick={handleLogout}>Logout</button>
      <hr />

      <h3>{form.id ? 'Edit Product' : 'Add Product'}</h3>
      <form onSubmit={handleSubmit}>
        <input placeholder="Product Name" value={form.product_name} onChange={e => setForm({...form, product_name: e.target.value})} required />
        <input placeholder="Description" value={form.description} onChange={e => setForm({...form, description: e.target.value})} />
        <input type="number" step="0.01" placeholder="Price" value={form.price} onChange={e => setForm({...form, price: e.target.value})} required />
        <input type="number" placeholder="Quantity" value={form.quantity} onChange={e => setForm({...form, quantity: e.target.value})} required />
        <button type="submit">{form.id ? 'Update' : 'Add'}</button>
        {form.id && <button type="button" onClick={() => setForm({ id: null, product_name: '', description: '', price: '', quantity: '' })}>Cancel</button>}
      </form>

      <hr />
      <h3>Products</h3>
      <table border="1" cellPadding="8" style={{ width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {products.map(p => (
            <tr key={p.id}>
              <td>{p.product_name}</td>
              <td>{p.description}</td>
              <td>${p.price}</td>
              <td>{p.quantity}</td>
              <td>
                <button onClick={() => handleEdit(p)}>Edit</button>
                <button onClick={() => handleDelete(p.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default App;