/**
 * Local module dependency imports
 */
var configGen = require('./lib/config');
var config = configGen.getConfig(process.env.CONFIG_PATH);

/**
 * Web server dependency imports
 */
var express = require('express'); // Web server
var logger = require('morgan'); // Logging
var bodyParser = require('body-parser');

var app = express();

/**
 * Database dependency imports
 */
var mongoose = require('mongoose');

// Start Mongodb
mongoose.connect(genMongoConnectionString(), { useNewUrlParser: true });

/**
 * Middleware, configuring body-parser and logging.
 */
app.use(logger('dev'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended:false}));

/**
 * Router objects
 */
var indexRoute = require('./routes/index');
app.use('/', indexRoute);

var usersRouter = require('./routes/users');
app.use('/api', usersRouter);

//TODO: Write up S3 client

function genMongoConnectionString () {
    const mongoDockerContainerName = config.mongoDockerContainerName;
    const mongoPort = config.mongoPort;
    const mongoDBName = config.mongoDBName;
    const mongoUsername = config.mongoUsername;
    const mongoPassword = config.mongoPassword;

    return 'mongodb://' + mongoUsername + ':' + mongoPassword + '@' + mongoDockerContainerName + ':' + mongoPort + '/' + mongoDBName;
}

module.exports = app;
