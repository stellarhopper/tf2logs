/**
  Used by command line programs to select a proper NODE_ENV.
  Usage: require('../lib/environmentchooser')(function(environment){
    doStuff();
  });
*/

module.exports = function(fn) {
  //set default environment
  var environment = 'development';

  //search the switches given from the command line to decide the environment to use.
  //skipping the first two tokens which will be node and this file
  for(var i = 2; i < process.argv.length; ++i) {
    var token = process.argv[i];
    switch(token) {
      case '-d':
        environment = 'development';
      break;
      case '-t':
        environment = 'test';
      break;
      case '-q':
        environment = 'qa';
      break;
      case '-p':
        environment = 'production';
      break;
      default: throw new Error("The switch '"+token+"' could not be recognized.");
    }
  }

  //setting the NODE_ENV environment variable, which Connect and Express use to configure themselves
  process.env.NODE_ENV = environment;

  //run what needs running
  fn(environment);
};