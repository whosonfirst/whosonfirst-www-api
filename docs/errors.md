In addition to any already [assigned HTTP status codes](https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml) The Who's On First API assigns specific meaning to certain codes and defines the following additional status codes for representing errors or a failure scenario, across all API methods:

<a name="mapzen"></a>
### Mapzen


| Error code | Error message |
| :--- | :--- |
| `400` | ApiDisabled |
| `401` | KeyDisabled |
| `403` | KeyError |
| `404` | ApiUnknown |
| `429` | Queries per minute/hour/day exceeded |

<a name="client"></a>
### Client-side

| Error code | Error message |
| :--- | :--- |
| `450` | Unknown error. || `452` | Insufficient parameters. || `453` | Missing parameter. || `454` | Invalid parameter. || `478` | Insufficient permissions for this API key. || `481` | Unauthorized host for this API key. || `482` | API key not configured for use with this method. || `483` | Invalid API key. || `484` | API key missing. || `497` | Output format is disallowed for this API method. || `498` | API method is disabled. || `499` | API method not found. |
<a name="server"></a>
### Server-side

| Error code | Error message |
| :--- | :--- |
| `512` | Something we tried to do didn&#039;t work. This is our fault, not yours. |
<a name="custom"></a>
### Custom

Individual API methods may define their own status codes within the `432-449` and `513-599` range on a per-method basis. Status codes in this range _may_ be used with different meanings by different API methods and it is left to API consumers to account for those differences.

The status codes defined above (`450`, `452-499`, and `512`) are unique and common to all API methods.