//Require the dev-dependencies
let chai = require('chai');
let chaiHttp = require('chai-http');
let should = chai.should();
let app = require('../cir/application_server/app_server');

chai.use(chaiHttp);

describe('App', function() {
	
	
	it('Test Compare Trend - author', (done) => {
	chai.request(app)
		.get('/api/get-publications-trend-citation/{"values":["Caregiver status affects medication adherence among older home care clients with heart failure."]}')
		.end((err, res) => {
			res.should.have.status(200);
			res.body.should.be.a('array');
			res.body.length.should.be.eql(2);
			
			res.body.should.be.eql([{"title":"caregiver status affects medication adherence among older home care clients with heart failure.","year":"2007","count":1},{"title":"caregiver status affects medication adherence among older home care clients with heart failure.","year":"2008","count":2}]);
			done();
		});
	});
	
	it('Test Trend - venue', (done) => {
	chai.request(app)
		.get('/api/get-top-N-X-Y/5/author/venue/arxiv')
		.end((err, res) => {
			res.should.have.status(200);
			res.body.should.be.a('array');
			res.body.length.should.be.eql(5);
			
			res.body.should.be.eql([{"author":"francisco marcos de assis","count":1,"year":[2016]},{"author":"radford m. neal","count":1,"year":[2015]},{"author":"yann lecun","count":1,"year":[2011]},{"author":"karol gregor","count":1,"year":[2011]},{"author":"rebecca f. bruce","count":1,"year":[1997]}]);
			done();
		});
	});
	
	it('Test Trend - citation', (done) => {
	chai.request(app)
		.get('/api/get-publications-trend-citation/{"values":["Caregiver status affects medication adherence among older home care clients with heart failure."]}')
		.end((err, res) => {
			res.should.have.status(200);
			res.body.should.be.a('array');
			res.body.length.should.be.eql(2);
			
			res.body.should.be.eql([{"title":"caregiver status affects medication adherence among older home care clients with heart failure.","year":"2007","count":1},{"title":"caregiver status affects medication adherence among older home care clients with heart failure.","year":"2008","count":2}]);
			done();
		});
	});
	
	it('Test Citation web - citation', (done) => {
	chai.request(app)
		.get('/api/get-citation-network/Caregiver status affects medication adherence among older home care clients with heart failure./incitations')
		.end((err, res) => {
			res.should.have.status(200);
			res.body.connections.should.be.a('array');
			res.body.connections.length.should.be.eql(4);
			res.body.data.should.be.a('array');
			res.body.data.length.should.be.eql(5);
			
			res.body.should.be.eql({"data":[{"id":"caregiver status affects medication adherence among older home care clients with heart failure.","title":"caregiver status affects medication adherence among older home care clients with heart failure.","level":1,"year":2012},{"id":"moc-ps(sm) cme article: abdominoplasty.","title":"moc-ps(sm) cme article: abdominoplasty.","level":2,"year":2008},{"id":"optical three-axis tactile sensor for robotic fingers","title":"optical three-axis tactile sensor for robotic fingers","level":2,"year":2008},{"id":"a golden age for malaria research and innovation","title":"a golden age for malaria research and innovation","level":2},{"id":"heterogeneity of signal transducer and activator of transcription binding sites in the long-terminal repeats of distinct hiv-1 subtypes","title":"heterogeneity of signal transducer and activator of transcription binding sites in the long-terminal repeats of distinct hiv-1 subtypes","level":2,"year":2007}],"connections":[{"source":"moc-ps(sm) cme article: abdominoplasty.","target":"caregiver status affects medication adherence among older home care clients with heart failure."},{"source":"optical three-axis tactile sensor for robotic fingers","target":"caregiver status affects medication adherence among older home care clients with heart failure."},{"source":"a golden age for malaria research and innovation","target":"caregiver status affects medication adherence among older home care clients with heart failure."},{"source":"heterogeneity of signal transducer and activator of transcription binding sites in the long-terminal repeats of distinct hiv-1 subtypes","target":"caregiver status affects medication adherence among older home care clients with heart failure."}]});
			done();
		});
	});
	
	
	
	it('Test top N X of Y web', (done) => {
	chai.request(app)
		.get('/api/get-top-N-X-Y/5/author/venue/arxiv')
		.end((err, res) => {
			res.should.have.status(200);
			res.body.should.be.a('array');
			res.body.length.should.be.eql(5);
			
			res.body.should.be.eql([{"author":"francisco marcos de assis","count":1,"year":[2016]},{"author":"radford m. neal","count":1,"year":[2015]},{"author":"yann lecun","count":1,"year":[2011]},{"author":"karol gregor","count":1,"year":[2011]},{"author":"rebecca f. bruce","count":1,"year":[1997]}]);
			done();
		});
	});
});
