const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path           = require( 'path' );
const fs             = require( 'fs' );

const BLOCKS_DIR = path.resolve( __dirname, 'blocks' );
const entries    = {};

if ( fs.existsSync( BLOCKS_DIR ) ) {
    fs.readdirSync( BLOCKS_DIR )
        .filter( dir => fs.statSync( path.join( BLOCKS_DIR, dir ) ).isDirectory() )
        .forEach( dir => {
            const indexPath = path.join( BLOCKS_DIR, dir, 'index.js' );
            const viewPath  = path.join( BLOCKS_DIR, dir, 'view.js' );
            if ( fs.existsSync( indexPath ) ) entries[ `${dir}/index` ] = indexPath;
            if ( fs.existsSync( viewPath ) )  entries[ `${dir}/view` ]  = viewPath;
        } );
}

module.exports = {
    ...defaultConfig,
    entry:  entries,
    output: {
        ...defaultConfig.output,
        path:     path.resolve( __dirname, 'build' ),
        filename: '[name].js',
    },
};
