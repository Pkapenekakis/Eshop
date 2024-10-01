const { Migration } = require('migrations');

module.exports = {
  async up(db) {
    await migrate(db, `
      CREATE TABLE IF NOT EXISTS products (
        id SERIAL PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        img VARCHAR(255),
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        user_username VARCHAR(255) NOT NULL
      );
    `);
  },

  async down(db) {
    await db.query('DROP TABLE IF EXISTS products;');
  },
};