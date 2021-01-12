const mix      = require('laravel-mix');
const command  = require('node-cmd');
const glob     = require('glob');
const beautify = require('js-beautify').html;
const fs       = require('fs');

module.exports = {
	apply( compiler ) {
		compiler.hooks.done.tap('Blader Build Plugin', () => {
			command.get('php blader build', ( error, stdout, stderr ) => {
				console.log(error ? stderr : stdout);

				if ( mix.inProduction() ) {
					glob('compiled/**/*.html', {}, function ( error, files ) {
						if ( error ) {
							console.log(error);
						}

						files.forEach(function ( file ) {
							fs.readFile(file, 'utf8', function ( error, data ) {
								if ( error ) {
									console.log(error);
								}

								let beautified = beautify(data, {
									indent_size: 4,
									indent_with_tabs: true,
									preserve_newlines: false,
								});

								fs.writeFile(file, beautified, function ( error ) {
									if ( error ) {
										console.log(error);
									}
								});
							});
						});
					});
				}
			});
		});
	}
}