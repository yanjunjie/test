
//http://localhost/
const host = window.location.protocol + "//" + window.location.host + "/";

export function baseURL(uri) {
	uri=uri?uri:'';
	return host+uri;
}
