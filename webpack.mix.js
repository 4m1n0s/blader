const mix     = require('laravel-mix');
const command = require('node-cmd');

mix.setPublicPath('source/assets')
   .js('source/_assets/js/app.js', 'js')
   .sass('source/_assets/sass/app.scss', 'css')
   .browserSync({
	   server: 'compiled',
	   files: [
		   'compiled/**/*',
		   {
			   match: ['source/**/*.blade.php', '!source/assets/**/*'],
			   fn: function ( event, file ) {
				   command.get('php blader build', ( error, stdout, stderr ) => {
					   console.log(error ? stderr : stdout);
				   });
			   }
		   }
	   ],
	   notify: false
   })
   .webpackConfig({
	   plugins: [
		   require('./blader.plugin'),
	   ]
   })
   .disableSuccessNotifications();