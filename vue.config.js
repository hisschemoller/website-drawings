module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://website-drawings.localdev/api.php',
        changeOrigin: true,
      },
    },
  },
};
