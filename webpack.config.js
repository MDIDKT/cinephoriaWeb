const Encore = require('@symfony/webpack-encore');

// Configure l'environnement runtime si ce n'est pas déjà fait
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // Répertoire où les assets compilés seront sauvegardés
    .setOutputPath('public/build/')
    // Chemin public utilisé par le serveur pour accéder aux fichiers compilés
    .setPublicPath('/build')
    // Active le loader PostCSS
    .enablePostCssLoader()

    /*
     * Configurer les entrées (entrypoints)
     * Chaque point d’entrée produira un fichier JavaScript et un fichier CSS (si CSS est importé)
     */
    .addEntry('app', './assets/app.js')
    // Vous pouvez ajouter d'autres entrées ici si nécessaire
    // .addEntry('another', './assets/another.js')

    // Active le bridge Symfony UX Stimulus (utilisé dans assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // Permet de diviser les fichiers en plus petits morceaux (optimisation Webpack)
    .splitEntryChunks()

    // Active le fichier runtime.js (utile sauf pour les applications à page unique)
    .enableSingleRuntimeChunk()

    /*
     * Fonctionnalités supplémentaires (voir Symfony Webpack Encore Doc)
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction()) // Active les noms de fichiers hashés en production

    // Configurations Babel
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-transform-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // Active React (si nécessaire)
    .enableReactPreset()

    // Active le plugin `manifest.json` par défaut (aucune configuration nécessaire)
    .configureManifestPlugin((options) => {
        options.fileName = 'manifest.json'; // Assurez-vous que ce fichier est généré comme attendu
    });
;

module.exports = Encore.getWebpackConfig();