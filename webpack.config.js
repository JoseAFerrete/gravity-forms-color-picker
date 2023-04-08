const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = (env, { mode = 'development' }) => {
  const target = mode !== 'production' ? 'frontend.dev' : 'frontend';
  return {
    entry: './assets/js/index.js',
    output: {
      filename: target + '.js',
      path: path.resolve(__dirname, 'assets/compiled'),
      publicPath: '/wp-content/plugins/gf-color-picker/assets/compiled/',
    },
    module: {
      rules: [
        {
          test: /\.s[ac]ss$/i,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: target + '.css',
              },
            },
            {
              loader: 'extract-loader',
            },
            // Translates CSS into CommonJS
            {
              loader: 'css-loader',
              options: { url: false },
            },
            // Postcss loader
            'postcss-loader',
            // Compiles Sass to CSS
            'sass-loader',
          ],
        },
      ],
    },
    optimization: {
      minimizer: [
        new TerserPlugin({
          parallel: true,
          terserOptions: {
            // https://github.com/webpack-contrib/terser-webpack-plugin#terseroptions
          },
        }),
      ],
    },
    externals: {
      jquery: 'jQuery',
    },
  };
};
