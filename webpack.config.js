// eslint-disable-next-line @typescript-eslint/no-var-requires
const Encore = require('@symfony/webpack-encore');
if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')

  .addEntry('app', './assets/app.ts')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())

  .configureBabel((config) => {
    config.plugins.push('@babel/plugin-proposal-class-properties');
  })

  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
  })

  .enableSassLoader()
  .enableVueLoader(() => ({}), {
    runtimeCompilerBuild: true,
  })
  .enableTypeScriptLoader()
  .addAliases({
    '@': '/assets',
  });

module.exports = Encore.getWebpackConfig();
