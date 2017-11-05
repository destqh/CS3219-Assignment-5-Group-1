//Require the dev-dependencies
let chai = require('chai');
let chaiHttp = require('chai-http');
let should = chai.should();
let app = require('../cir/app');

chai.use(chaiHttp);

describe('App', function() {
	/*
	 * Test the API to get Top Authors
	 */
	it('Test Top Authors', (done) => {
	chai.request(app)
		.get('/api/top-authors?rank=10&venue=arxiv')
		.end((err, res) => {
			res.should.have.status(200);
			res.body.should.be.a('array');
			res.body.length.should.be.eql(10);
			
			res.body.should.be.eql([
				{"name":"Chandrasekhar Narayanaswami","count":1},
				{"name":"Gilles Daniel","count":1},
				{"name":"Sorin Solomon","count":1},
				{"name":"Dominique Méry","count":1},
				{"name":"Stephan Merz","count":1},
				{"name":"Tukaram D. Dongale","count":1},
				{"name":"P. K. Gaikwad","count":1},
				{"name":"Rajanish K. Kamat","count":1},
				{"name":"Hammurabi Mendes","count":1},
				{"name":"Maurice Herlihy","count":1}]);
			done();
		});
	});
});