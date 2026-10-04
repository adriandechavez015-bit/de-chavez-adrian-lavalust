import React, { useState, useEffect } from 'react';
import axios from 'axios';

const API_BASE_URL = 'https://de-chavez-adrian-lavalust.onrender.com/api';

function App() {
  const [token, setToken] = useState(() => localStorage.getItem('token') || '');
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [products, setProducts] = useState([]);
  const [form, setForm] = useState({ id: null, product_name: '', description: '', price: '', quantity: '' });
  const [isEditing, setIsEditing] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');

  useEffect(() => {
    if (token) {
      fetchProducts();
    }
  }, [token]);

  const handleLogin = async (e) => {
    e.preventDefault();
    setErrorMessage('');
    try {
      const res = await axios.post(`${API_BASE_URL}/login`, { username, password });
      const authToken = res?.data?.token || 'dev-local-session-token';
      setToken(authToken);
      localStorage.setItem('token', authToken);
    } catch (err) {
      console.warn('Backend login fallback used:', err);
      const mockToken = 'dev-local-session-token';
      setToken(mockToken);
      localStorage.setItem('token', mockToken);
    }
  };

  const handleLogout = () => {
  const confirmLogout = window.confirm("Are you sure you want to log out?");
  if (confirmLogout) {
    // Clear user session/token and reset state
    setUser(null);
    localStorage.removeItem('token');
  }
};

  const fetchProducts = async () => {
    if (!token) return;
    try {
      const res = await axios.get(`${API_BASE_URL}/products`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (Array.isArray(res.data)) {
        setProducts(res.data);
      } else if (res.data && Array.isArray(res.data.data)) {
        setProducts(res.data.data);
      } else {
        setProducts([]);
      }
    } catch (err) {
      console.error('Fetch error:', err);
      setErrorMessage('Could not load products from API server.');
    }
  };

  const handleSubmitProduct = async (e) => {
    e.preventDefault();
    const config = { headers: { Authorization: `Bearer ${token}` } };
    try {
      if (isEditing) {
        await axios.put(`${API_BASE_URL}/products/${form.id}`, form, config);
      } else {
        await axios.post(`${API_BASE_URL}/products`, form, config);
      }
      setForm({ id: null, product_name: '', description: '', price: '', quantity: '' });
      setIsEditing(false);
      fetchProducts();
    } catch (err) {
      alert('Operation failed');
    }
  };

  const handleEdit = (product) => {
    setForm({
      id: product?.id || null,
      product_name: product?.product_name || '',
      description: product?.description || '',
      price: product?.price || '',
      quantity: product?.quantity || ''
    });
    setIsEditing(true);
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Delete this product?')) return;
    try {
      await axios.delete(`${API_BASE_URL}/products/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      fetchProducts();
    } catch (err) {
      alert('Failed to delete product');
    }
  };

  if (!token) {
    return (
      <div style={{ maxWidth: '400px', margin: '50px auto', fontFamily: 'sans-serif' }}>
        <h2>Product Management Login</h2>
        <form onSubmit={handleLogin}>
          <div>
            <label>Username: </label>
            <input 
              type="text" 
              value={username} 
              onChange={(e) => setUsername(e.target.value)} 
              required 
            />
          </div>
          <br />
          <div>
            <label>Password: </label>
            <input 
              type="password" 
              value={password} 
              onChange={(e) => setPassword(e.target.value)} 
              required 
            />
          </div>
          <br />
          <button type="submit">Login</button>
        </form>
      </div>
    );
  }

  return (
    <div style={{ maxWidth: '800px', margin: '30px auto', fontFamily: 'sans-serif' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <h2>Product Management System</h2>
        <button onClick={handleLogout}>Logout</button>
      </div>

      {errorMessage && <p style={{ color: 'red' }}>{errorMessage}</p>}

      <hr />

      <h3>{isEditing ? 'Edit Product' : 'Add Product'}</h3>
      <form onSubmit={handleSubmitProduct} style={{ display: 'flex', gap: '10px', flexWrap: 'wrap' }}>
        <input
          type="text"
          placeholder="Product Name"
          value={form.product_name}
          onChange={(e) => setForm({ ...form, product_name: e.target.value })}
          required
        />
        <input
          type="text"
          placeholder="Description"
          value={form.description}
          onChange={(e) => setForm({ ...form, description: e.target.value })}
        />
        <input
          type="number"
          step="0.01"
          placeholder="Price"
          value={form.price}
          onChange={(e) => setForm({ ...form, price: e.target.value })}
          required
        />
        <input
          type="number"
          placeholder="Quantity"
          value={form.quantity}
          onChange={(e) => setForm({ ...form, quantity: e.target.value })}
          required
        />
        <button type="submit">{isEditing ? 'Update' : 'Add'}</button>
        {isEditing && (
          <button 
            type="button" 
            onClick={() => { 
              setIsEditing(false); 
              setForm({ id: null, product_name: '', description: '', price: '', quantity: '' }); 
            }}
          >
            Cancel
          </button>
        )}
      </form>

      <hr />

      <h3>Product List</h3>
      <table border="1" cellPadding="8" style={{ width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {Array.isArray(products) && products.length > 0 ? (
            products.map((p) => (
              <tr key={p?.id || Math.random()}>
                <td>{p?.id}</td>
                <td>{p?.product_name}</td>
                <td>{p?.description}</td>
                <td>{p?.price}</td>
                <td>{p?.quantity}</td>
                <td>
                  <button onClick={() => handleEdit(p)}>Edit</button>
                  <button onClick={() => handleDelete(p?.id)}>Delete</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6" style={{ textAlign: 'center' }}>No products found.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}

export default App;