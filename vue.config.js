module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://website-drawings.localdev/backend/api.php',
        changeOrigin: true,
      },
    },
  },
};
