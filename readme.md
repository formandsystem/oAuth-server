# Form&System oAuth Server

[![Build Status](https://travis-ci.org/formandsystem/oAuth-server.svg)](https://travis-ci.org/formandsystem/oAuth-server)

oAuth Server for the Form&System cms.

## Error Codes

Code | HTTP status code| Error message | Description
----|----|----|----
100 | 401 | Invalid request access token | The access token used to perform the request may be wrong or expired
101 | 401 | Invalid request scope | You don't have the appropriate access rights to perform this request
102 | 400 | Invalid client credentials | You must provide valid client credentials as well as a valid grant type and scope
102 | 406 | Unsupported accept header | Provide a valid accept header
103 | 415 | Unsupported media type | You must provide a supported media type in your content type header
201 | 403 | Invalid access token | The access token you checked is invalid, it may be wrong or expired
202 | 403 | Invalid scope | The access token you checked does not have the desired access rights
300 | 400 | Missing parameter | The parameter 'parameter_name' must be provided
304 | 400 | Not found | The resource was not found
