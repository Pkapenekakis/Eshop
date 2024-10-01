const express = require("express");
const cors = require('cors');
const fs = require("fs"); //read from files
const { Pool } = require('pg');

/* 
  We can have a port as environment. If we dont define 
  environment then application will run in port 3000
*/
const port = process.env.PORT || 3000;

const pool = new Pool({
  user: 'db_user',
  host: 'database',
  database: 'products_database',
  password: 'db_password',
  port: 5431,
});

app.use((req, res, next) => {
  res.setHeader("Access-Control-Allow-Origin", "*");
  res.setHeader("Access-Control-Allow-Methods", "POST, GET, PUT");
  res.setHeader("Access-Control-Allow-Headers", "Content-Type");
  next();
})

app.use(cors({origin: 'http://localhost:8000'}));

/*
  Express.js is the most popular web framework for Node.js. It is designed for building web applications and APIs
  official website: https://expressjs.com/
*/
const app = express();
/*
const allowedOrigins = ['http://localhost:8000'];
app.use(cors({
  origin: function(origin, callback){
    if (!origin) {
      return callback(null, true);
    }

    if (allowedOrigins.includes(origin)) {
      const msg = 'The CORS policy for this site does not allow access from the specified Origin.';
      return callback(new Error(msg), false);
    }
    return callback(null, true);
  } 

})); */




/*
CORS stands for Cross-Origin Resource Sharing, 
and it is a security feature implemented by web browsers 
to control and restrict web page scripts from making requests 
to a different domain than the one that served the web 
page. In other words, CORS is a mechanism that allows 
or restricts web browsers from making requests to 
different origins (domains) for security reasons.
 */

// API routes

// Create a product (POST)
app.post('/products', async (req, res) => {
  // Assuming authentication and authorization logic is implemented
  const { title, img, price, quantity, user_username } = req.body;

  try {
    const result = await pool.query(
      'INSERT INTO products(title, img, price, quantity, user_username) VALUES($1, $2, $3, $4, $5) RETURNING *',
      [title, img, price, quantity, user_username]
    );

    res.status(201).json(result.rows[0]);
  } catch (error) {
    console.error('Error creating product', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Get all products (GET)
app.get('/products', async (req, res) => {
  try {
    const result = await pool.query('SELECT * FROM products');
    res.json(result.rows);
  } catch (error) {
    console.error('Error fetching products', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Get a product by ID (GET)
app.get('/products/:id', async (req, res) => {
  const productId = parseInt(req.params.id);

  try {
    const result = await pool.query('SELECT * FROM products WHERE id = $1', [productId]);

    if (result.rows.length === 0) {
      res.status(404).json({ message: 'Product not found' });
    } else {
      res.json(result.rows[0]);
    }
  } catch (error) {
    console.error('Error fetching product by ID', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

app.listen(port, () => {
  console.log("Products service running in PORT " + port);
});
