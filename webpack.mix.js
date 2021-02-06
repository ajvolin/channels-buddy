const mix = require('laravel-mix');
const ChunkRenamePlugin = require("webpack-chunk-rename-plugin");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    output: {
        publicPath: '/',
        filename: '[name].js',
        chunkFilename: 'js/[name].js?id=[chunkhash]'
    },
    plugins: [
        new ChunkRenamePlugin({
            initialChunksWithEntry: true,
            '/js/vendor': '/js/vendor.js'
        }),
    ],
})
.js('resources/js/app.js', 'js')
.extract();

if (mix.inProduction()) {
    mix.version()
        .sourceMaps();
}

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);
