/// <reference types="cypress" />
// ***********************************************************
// This example plugins/index.js can be used to load plugins
//
// You can change the location of this file or turn off loading
// the plugins file with the 'pluginsFile' configuration option.
//
// You can read more here:
// https://on.cypress.io/plugins-guide
// ***********************************************************

import * as fs from 'fs-extra';
import * as path from 'path';

function getConfigurationByFile(file) {
    const pathToConfigFile = path.resolve('./cypress', 'config', `${file}.json`)
    const raw = fs.readFileSync(pathToConfigFile);

    return JSON.parse(raw);
}

// This function is called when a project is opened or re-opened (e.g. due to
// the project's config changing)

/**
 * @type {Cypress.PluginConfig}
 */
export default (config) => {
    // `config` is the resolved Cypress config
    // accept a configFile value or use docker by default
    const file = config.env.configFile || 'docker';
    const configurationFromFile = getConfigurationByFile(file);

    return { ...configurationFromFile, env: { ...configurationFromFile.env, ...config.env } };
}
