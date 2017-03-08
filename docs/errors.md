<a name="error-codes"></a>
## Error codes

In addition to any already [assigned HTTP status codes](https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml) The Who's On First API defines the following additional status codes for representing errors or a failure scenario, across all API methods:

* `450` &#8212;  Unknown error
* `452` &#8212;  Insufficient parameters
* `453` &#8212;  Missing parameter
* `454` &#8212;  Invalid parameter
* `455` &#8212;  Invalid upload response
* `456` &#8212;  Missing upload body
* `457` &#8212;  Upload exceeded maximum filesize
* `458` &#8212;  Invalid mime-type
* `460` &#8212;  Invalid user
* `461` &#8212;  User is disabled
* `462` &#8212;  User is deleted
* `478` &#8212;  Insufficient permissions for this API key
* `479` &#8212;  Invalid access token for this API key
* `481` &#8212;  Unauthorized host for this API key
* `482` &#8212;  API key not configured for use with this method
* `483` &#8212;  Invalid API key
* `484` &#8212;  API key missing
* `490` &#8212;  Access token has insuffient permissions
* `491` &#8212;  Access token is expired
* `492` &#8212;  Access token is disabled
* `493` &#8212;  Invalid access token
* `494` &#8212;  Access token missing
* `497` &#8212;  Output format is disallowed for this API method
* `498` &#8212;  API method is disabled
* `499` &#8212;  API method not found
* `512` &#8212;  Something we tried to do didn&#039;t work. This is our fault, not yours.

Individual API methods may define their own status codes within the `432-449` and `513-599` range on a per-method basis. Status codes in this range _may_ be used with different meanings by different API methods and it is left to API consumers to account for those differences.

The status codes defined above (`450`, `452-499`, and `512`) are unique and common to all API methods.