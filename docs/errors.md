<a name="error-codes"></a>
## Error codes

In addition to any already [assigned HTTP status codes](https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml) The Who's On First API defines the following additional status codes for representing errors or a failure scenario, across all API methods:

| Error code | Error message |
| :--- | :--- |
| `450` | Unknown error |
| `452` | Insufficient parameters |
| `453` | Missing parameter |
| `454` | Invalid parameter |
| `455` | Invalid upload response |
| `456` | Missing upload body |
| `457` | Upload exceeded maximum filesize |
| `458` | Invalid mime-type |
| `460` | Invalid user |
| `461` | User is disabled |
| `462` | User is deleted |
| `478` | Insufficient permissions for this API key |
| `479` | Invalid access token for this API key |
| `481` | Unauthorized host for this API key |
| `482` | API key not configured for use with this method |
| `483` | Invalid API key |
| `484` | API key missing |
| `490` | Access token has insuffient permissions |
| `491` | Access token is expired |
| `492` | Access token is disabled |
| `493` | Invalid access token |
| `494` | Access token missing |
| `497` | Output format is disallowed for this API method |
| `498` | API method is disabled |
| `499` | API method not found |
| `512` | Something we tried to do didn&#039;t work. This is our fault, not yours. |

Individual API methods may define their own status codes within the `432-449` and `513-599` range on a per-method basis. Status codes in this range _may_ be used with different meanings by different API methods and it is left to API consumers to account for those differences.

The status codes defined above (`450`, `452-499`, and `512`) are unique and common to all API methods.