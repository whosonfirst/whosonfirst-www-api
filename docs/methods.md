## API methods

### api.spec

* [api.spec.errors](#api.spec.errors)
* [api.spec.formats](#api.spec.formats)
* [api.spec.methods](#api.spec.methods)

<a name="api.spec.errors"></a>
#### api.spec.errors

Return the list of API error responses common to all methods.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=api.spec.errors&api_key=your-mapzen-api-key'

{
    "errors": [
        {
            "code": 450,
            "message": "Unknown error."
        },
        {
            "code": 452,
            "message": "Insufficient parameters."
        }
    ],
    "stat": "ok"
}
```
_This example response has been truncated for the sake of brevity._

<a name="api.spec.formats"></a>
#### api.spec.formats

Return the list of valid API response formats, including the default format

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=api.spec.formats&api_key=your-mapzen-api-key'

{
    "formats": [
        "csv",
        "geojson",
        "json",
        "meta"
    ],
    "default_format": "json",
    "stat": "ok"
}
```

<a name="api.spec.methods"></a>
#### api.spec.methods

Return the list of available API response methods.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=api.spec.methods&api_key=your-mapzen-api-key'

{
    "methods": [
        {
            "name": "api.spec.methods",
            "method": "GET",
            "description": "Return the list of available API response methods.",
            "requires_auth": 0,
            "parameters": [

            ],
            "errors": [

            ],
            "extras": 0,
            "paginated": 0,
            "disallow_formats": [
                "csv",
                "geojson",
                "meta"
            ]
        },
        {
            "name": "api.spec.errors",
            "method": "GET",
            "description": "Return the list of API error responses common to all methods.",
            "requires_auth": 0,
            "parameters": [

            ],
            "errors": [

            ],
            "extras": 0,
            "paginated": 0,
            "disallow_formats": [
                "csv",
                "geojson",
                "meta"
            ]
        }
    ],
    "stat": "ok"
}
```
_This example response has been truncated for the sake of brevity._


### api.test

* [api.test.echo](#api.test.echo)
* [api.test.error](#api.test.error)

<a name="api.test.echo"></a>
#### api.test.echo

A testing method which echo&#039;s all parameters back in the response.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=api.test.echo&api_key=your-mapzen-api-key'

{
    "stat": "ok"
}
```

<a name="api.test.error"></a>
#### api.test.error

Return a test error from the API

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=api.test.error&api_key=your-mapzen-api-key'

null
```


### mapzen.places.brands

* [mapzen.places.brands.getInfo](#mapzen.places.brands.getInfo) _experimental_
* [mapzen.places.brands.getList](#mapzen.places.brands.getList) _experimental_
* [mapzen.places.brands.search](#mapzen.places.brands.search) _experimental_

<a name="mapzen.places.brands.getInfo"></a>
#### mapzen.places.brands.getInfo

Return information about a specific brand

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `id` |  |  1125148929 | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `434` | Missing brand ID |
| `435` | Invalid brand ID |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.brands.getInfo&api_key=your-mapzen-api-key&id=1125148929'

{
    "brand": {
        "wof:brand_size": "L",
        "wof:lastmodified": 1511400709,
        "wof:brand_name": "White Castle",
        "wof:brand_id": 1125148929
    },
    "stat": "ok"
}
```

<a name="mapzen.places.brands.getList"></a>
#### mapzen.places.brands.getList

Return a list of all the known brands

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `brand_size` | A valid brand size to scope queries by. You may prefix the brand size with &lt;, &lt;=, &gt; or &gt;= to define simple range queries. |  XXS | no |
| `min_brand_size` | A mininum (inclusive) brand size to scope queries to. |  M | no |
| `max_brand_size` | A maximum (inclusive) brand size to scope queries to. |  XL | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid brand size |
| `433` | Invalid brand size range |
| `513` | Unable to retrieve brands |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.brands.getList&api_key=your-mapzen-api-key&brand_size=XXS&min_brand_size=M&max_brand_size=XL&per_page=1'

{
    "brands": [
        {
            "wof:brand_size": "M",
            "wof:lastmodified": 1511400661,
            "wof:brand_name": "0 Waiting Time Locksmith Service",
            "wof:brand_id": 1125155555
        }
    ],
    "next_query": "method=mapzen.places.brands.getList&brand_size=XXS&min_brand_size=M&max_brand_size=XL&per_page=1&page=2",
    "total": 7125,
    "page": 1,
    "per_page": 1,
    "pages": 7125,
    "cursor": null,
    "stat": "ok"
}
```

<a name="mapzen.places.brands.search"></a>
#### mapzen.places.brands.search

Search for brands by name

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `q` |  |  Kroger | yes |
| `brand_size` | A valid brand size to scope queries by. You may prefix the brand size with &lt;, &lt;=, &gt; or &gt;= to define simple range queries. |  XXS | no |
| `min_brand_size` | A mininum (inclusive) brand size to scope queries to. |  M | no |
| `max_brand_size` | A maximum (inclusive) brand size to scope queries to. |  XL | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid brand size |
| `433` | Invalid brand size range |
| `434` | Missing query |
| `513` | Unable to retrieve brands |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.brands.search&api_key=your-mapzen-api-key&q=Kroger&brand_size=XXS&min_brand_size=M&max_brand_size=XL&per_page=1'

{
    "brands": [
        {
            "wof:brand_name": "Kroger",
            "wof:brand_id": 420574191,
            "edtf:inception": 1883,
            "wof:concordances": {
                "wk:page": "Kroger"
            },
            "wof:brand_size": "XL",
            "wof:lastmodified": 1511399895,
            "mz:is_current": 1
        }
    ],
    "next_query": null,
    "total": 2,
    "page": 1,
    "per_page": 1,
    "pages": 2,
    "cursor": null,
    "stat": "ok"
}
```


### mapzen.places.brands.sizes

* [mapzen.places.brands.sizes.getInfo](#mapzen.places.brands.sizes.getInfo) _experimental_
* [mapzen.places.brands.sizes.getList](#mapzen.places.brands.sizes.getList) _experimental_

<a name="mapzen.places.brands.sizes.getInfo"></a>
#### mapzen.places.brands.sizes.getInfo

Return details about a specific brand size

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `brand_size` |  |  M | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid brand size |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.brands.sizes.getInfo&api_key=your-mapzen-api-key&brand_size=M'

{
    "size": {
        "min": 51,
        "max": 100,
        "label": "medium",
        "id": 1141959927,
        "size": "M"
    },
    "stat": "ok"
}
```

<a name="mapzen.places.brands.sizes.getList"></a>
#### mapzen.places.brands.sizes.getList

Return a list of all the brand sizes

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.brands.sizes.getList&api_key=your-mapzen-api-key'

{
    "sizes": [
        {
            "min": 1,
            "max": 2,
            "label": "onesie",
            "id": 1158862561,
            "size": "O"
        },
        {
            "min": 3,
            "max": 5,
            "label": "extra-extra-extra small",
            "id": 1158864409,
            "size": "XXXS"
        },
        {
            "min": 6,
            "max": 10,
            "label": "extra-extra small",
            "id": 1141959937,
            "size": "XXS"
        },
        {
            "min": 11,
            "max": 20,
            "label": "extra small",
            "id": 1141959931,
            "size": "XS"
        },
        {
            "min": 21,
            "max": 50,
            "label": "small",
            "id": 1141959923,
            "size": "S"
        },
        {
            "min": 51,
            "max": 100,
            "label": "medium",
            "id": 1141959927,
            "size": "M"
        },
        {
            "min": 101,
            "max": 500,
            "label": "large",
            "id": 1141959925,
            "size": "L"
        },
        {
            "min": 501,
            "max": 5000,
            "label": "extra large",
            "id": 1141959929,
            "size": "XL"
        },
        {
            "min": 5001,
            "max": 10000,
            "label": "extra-extra large",
            "id": 1141959935,
            "size": "XXL"
        },
        {
            "min": 10001,
            "label": "extra-extra-extra large",
            "id": 1158864411,
            "size": "XXXL"
        }
    ],
    "stat": "ok"
}
```


### mapzen.places.brands.venues

* [mapzen.places.brands.venues.getList](#mapzen.places.brands.venues.getList) _experimental_

<a name="mapzen.places.brands.venues.getList"></a>
#### mapzen.places.brands.venues.getList

Return a list of venues for a specific brand

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `brand_id` |  |  1125148929 | yes |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `iso` | Ensure places belong to this (ISO) country code. |  CA | no |
| `country_id` | Ensure places belong to this country Who&#039;s On First ID. |  85633147 | no |
| `region_id` | Ensure places belong to this region Who&#039;s On First ID. |  85669831 | no |
| `locality_id` | Ensure places belong to this locality Who&#039;s On First ID. |  101736545 | no |
| `neighbourhood_id` | Ensure places belong to this neighbourhood Who&#039;s On First ID. |  102112179 | no |
| `concordance` | Query for places that have been concordified with this source. |  loc:id | no |
| `min_lastmod` | Limit results to places that have been modified on or since this date (encoded as a Unix timestamp). |  1493855252 | no |
| `max_lastmod` | Limit results to places that have been modified on or before this date (encoded as a Unix timestamp). |  1496783757 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `434` | Missing brand ID |
| `435` | Invalid brand ID |
| `513` | Unable to retrieve venues |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.brands.venues.getList&api_key=your-mapzen-api-key&brand_id=1125148929&iso=CA&country_id=85633147&region_id=85669831&locality_id=101736545&neighbourhood_id=102112179&concordance=loc:id&min_lastmod=1493855252&max_lastmod=1496783757&per_page=1'

{
    "places": [

    ],
    "next_query": null,
    "total": 0,
    "page": 1,
    "per_page": 1,
    "pages": 0,
    "cursor": null,
    "stat": "ok"
}
```


### mapzen.places.concordances

* [mapzen.places.concordances.getById](#mapzen.places.concordances.getById)
* [mapzen.places.concordances.getSources](#mapzen.places.concordances.getSources)

<a name="mapzen.places.concordances.getById"></a>
#### mapzen.places.concordances.getById

Return a Who&#039;s On First record (and all its concordances) by another source identifier.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `id` | The ID of concordance you are looking for |  3534 | yes |
| `source` | The source prefix of the concordance you are looking for |  gp:id | yes |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `433` | Missing &#039;source&#039; parameter |
| `513` | Failed to retrieve concordance |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.concordances.getById&api_key=your-mapzen-api-key&id=3534&source=gp:id&per_page=1'

{
    "concordances": [
        {
            "gp:id": 3534,
            "fb:id": "en.montreal",
            "wd:id": "Q340",
            "wk:page": "Montreal",
            "fct:id": "03c06bce-8f76-11e1-848f-cfd5bf3ef515",
            "qs:id": "239659",
            "loc:id": "n80132975",
            "tgn:id": "7013051",
            "qs_pg:id": "239659",
            "nyt:id": "N59179828586486930801",
            "gn:id": 6077243,
            "dbp:id": "Montreal",
            "wof:id": 101736545
        }
    ],
    "next_query": null,
    "total": 1,
    "page": 1,
    "per_page": 1,
    "pages": 1,
    "cursor": null,
    "stat": "ok"
}
```

<a name="mapzen.places.concordances.getSources"></a>
#### mapzen.places.concordances.getSources

List all the sources that Who&#039;s On First holds hands with.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.concordances.getSources&api_key=your-mapzen-api-key&per_page=1'

{
    "sources": [
        {
            "source": "sg:id",
            "concordances": 21674066
        }
    ],
    "next_query": "method=mapzen.places.concordances.getSources&per_page=1&page=2",
    "total": 57,
    "page": 1,
    "per_page": 1,
    "pages": 57,
    "cursor": null,
    "stat": "ok"
}
```


### mapzen.places

* [mapzen.places.getByLatLon](#mapzen.places.getByLatLon)
* [mapzen.places.getByPolyline](#mapzen.places.getByPolyline)
* [mapzen.places.getDescendants](#mapzen.places.getDescendants)
* [mapzen.places.getHierarchiesByLatLon](#mapzen.places.getHierarchiesByLatLon)
* [mapzen.places.getInfo](#mapzen.places.getInfo)
* [mapzen.places.getInfoMulti](#mapzen.places.getInfoMulti)
* [mapzen.places.getIntersects](#mapzen.places.getIntersects)
* [mapzen.places.getNearby](#mapzen.places.getNearby)
* [mapzen.places.getParentByLatLon](#mapzen.places.getParentByLatLon) _experimental_
* [mapzen.places.getRandom](#mapzen.places.getRandom)
* [mapzen.places.search](#mapzen.places.search)

<a name="mapzen.places.getByLatLon"></a>
#### mapzen.places.getByLatLon

Return Who&#039;s On First places intersecting a latitude and longitude

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `latitude` | A valid latitude coordinate. |  37.766633 | yes |
| `longitude` | A valid longitude coordinate. |  -122.417693 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Invalid placetype |
| `513` | Failed to perform lookup |

##### Notes

* This method differs from the whosonfirst.places.getAncestorsByLatLon method in two ways: 1. It returns a list of WOF places rather than hierarchies and 2. If a placetype filter is specified and no matching records are found no attempt will be made to find ancestors higher up the hierarchy. For example looking for an intersecting county or region if no locality is found.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getByLatLon&api_key=your-mapzen-api-key&latitude=37.766633&longitude=-122.417693&placetype=neighbourhood'

{
    "places": [
        {
            "wof:id": 85834637,
            "wof:parent_id": "1108830809",
            "wof:name": "Inner Mission",
            "wof:placetype": "neighbourhood",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 85887443,
            "wof:parent_id": "85922583",
            "wof:name": "Mission District",
            "wof:placetype": "neighbourhood",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        }
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.getByPolyline"></a>
#### mapzen.places.getByPolyline

Return Who&#039;s On First places intersecting each point along a polyline.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `polyline` | A valid polyline-encoded string. |  e_teFdj_jV|OzS_NlRbNdRqFdHt`AdsAqWlEqAkSug@nFxMfqB`jAaOhSfvCqb@tHjMx}I | yes |
| `precision` | The decimal precision for your polyline, for example 5 (Google) or 6 (Mapzen Valhalla) |  6 | no |
| `unique` | Signal that results should only contain the unique set of places that intersect all steps in the polyline) |  1 | no |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;polyline&#039; parameter |
| `433` | Invalid &#039;precision&#039; parameter |
| `436` | Invalid placetype |
| `513` | Failed to perform lookup |

##### Notes

* If you pass the &#039;unique&#039; flag please note that the set of unique places will be for the paginated slice of the polyline rather than the entire polyline itself. This may cause pagination results to look a bit weird and why the &#039;total&#039; pagination property will be set to null (since its count will reflect the total number of points in your polyline).
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getByPolyline&api_key=your-mapzen-api-key&polyline=e_teFdj_jV|OzS_NlRbNdRqFdHt`AdsAqWlEqAkSug@nFxMfqB`jAaOhSfvCqb@tHjMx}I&unique=1&placetype=postalcode&per_page=1'

{
    "places": [
        [
            {
                "wof:id": 554784673,
                "wof:parent_id": "85922583",
                "wof:name": "94105",
                "wof:placetype": "postalcode",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data-postalcode-us"
            }
        ]
    ],
    "next_query": "method=mapzen.places.getByPolyline&polyline=e_teFdj_jV%7COzS_NlRbNdRqFdHt%60AdsAqWlEqAkSug%40nFxMfqB%60jAaOhSfvCqb%40tHjMx%7DI&unique=1&placetype=postalcode&per_page=1&page=2",
    "total": null,
    "page": 1,
    "per_page": 1,
    "pages": 14,
    "cursor": null,
    "stat": "ok"
}
```

<a name="mapzen.places.getDescendants"></a>
#### mapzen.places.getDescendants

Return all the descendants for a Who&#039;s On First ID.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `id` | A valid Who&#039;s On First ID |  420780703 | yes |
| `name` | Query for this value in the wof:name field. |  Gowanus Heights | no |
| `names` | Query for this value across all name related fields. |  SF | no |
| `alt` | Query for this value across all alternate name related fields (variant, colloquial, unknown). |  Paris | no |
| `preferred` | Query for this value across all preferred name related fields. |  বেইজিং | no |
| `variant` | Query for this value across all variant name related fields. |  💩 | no |
| `placetype` | Ensure records match this placetype. |  microhood | no |
| `exclude_placetype` | Ensure records exclude this placetype. |  venue | no |
| `tags` | Query for places with one or more of these tags. |  diner | no |
| `iso` | Ensure places belong to this (ISO) country code. |  CA | no |
| `country_id` | Ensure places belong to this country Who&#039;s On First ID. |  85633147 | no |
| `region_id` | Ensure places belong to this region Who&#039;s On First ID. |  85669831 | no |
| `locality_id` | Ensure places belong to this locality Who&#039;s On First ID. |  101736545 | no |
| `neighbourhood_id` | Ensure places belong to this neighbourhood Who&#039;s On First ID. |  102112179 | no |
| `brand_id` | Ensure places belong to this Who&#039;s On First brand ID. |  1126128733 | no |
| `concordance` | Query for places that have been concordified with this source. |  loc:id | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `has_brand` | Filter results to include only those places that have a Who&#039;s On First brand ID. Valid options are: 1, 0 |  1 | no |
| `exclude` | Exclude places matching these criteria. |  nullisland | no |
| `include` | Include places matching these criteria. |  deprecated | no |
| `min_lastmod` | Limit results to places that have been modified on or since this date (encoded as a Unix timestamp). |  1493855252 | no |
| `max_lastmod` | Limit results to places that have been modified on or before this date (encoded as a Unix timestamp). |  1496783757 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. | _cXVl...c7MDs=_ | no |
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](pagination.md) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `513` | Unable to retrieve descendants |

##### Notes

* This API method uses [mixed](pagination.md#mixed) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getDescendants&api_key=your-mapzen-api-key&id=420780703&name=Gowanus Heights&names=SF&alt=Paris&preferred=বেইজিং&variant=💩&placetype=microhood&exclude_placetype=venue&tags=diner&category=&iso=CA&country_id=85633147&region_id=85669831&locality_id=101736545&neighbourhood_id=102112179&brand_id=1126128733&concordance=loc:id&is_current=1&is_ceased=1&is_deprecated=1&is_superseded=1&is_superseding=1&has_brand=1&exclude=nullisland&include=deprecated&min_lastmod=1493855252&max_lastmod=1496783757&per_page=1'

{
    "places": [

    ],
    "next_query": null,
    "total": 0,
    "page": 1,
    "per_page": 1,
    "pages": 0,
    "cursor": null,
    "stat": "ok"
}
```

<a name="mapzen.places.getHierarchiesByLatLon"></a>
#### mapzen.places.getHierarchiesByLatLon

Return the closest set of ancestors (hierarchies) for a latitude and longitude

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `latitude` | A valid latitude coordinate. |  37.777228 | yes |
| `longitude` | A valid longitude coordinate. |  -122.470779 | yes |
| `spr` | Format results as a standard place response (spr). |  1 | no |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Invalid placetype |
| `513` | Failed to perform lookup |
| `514` | Failed to perform standard place response (spr) lookup |

##### Notes

* This method differs from whosonfirst.places.getByLatLon method in two ways: 1. It returns a list of hierarchies rather than a WOF place record and 2. It will travel up the hierarchy until an ancestor is found. For example even if there is no locality matching a given lat, lon the code will try again looking for a matching region, and so on.
* The &#039;extras&#039; parameter is only honoured when the &#039;spr&#039; parameter is present.
* The following output formats are **disallowed** for this API method: [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getHierarchiesByLatLon&api_key=your-mapzen-api-key&latitude=37.777228&longitude=-122.470779&spr=1&placetype=neighbourhood'

{
    "hierarchies": [
        {
            "neighbourhood": {
                "wof:id": 85865919,
                "wof:parent_id": "1108830805",
                "wof:name": "Inner Richmond",
                "wof:placetype": "neighbourhood",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data"
            },
            "continent": {
                "wof:id": 102191575,
                "wof:parent_id": "-1",
                "wof:name": "North America",
                "wof:placetype": "continent",
                "wof:country": "",
                "wof:repo": "whosonfirst-data"
            },
            "macrohood": {
                "wof:id": 1108830805,
                "wof:parent_id": "85922583",
                "wof:name": "Richmond District",
                "wof:placetype": "macrohood",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data"
            },
            "country": {
                "wof:id": 85633793,
                "wof:parent_id": "102191575",
                "wof:name": "United States",
                "wof:placetype": "country",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data"
            },
            "locality": {
                "wof:id": 85922583,
                "wof:parent_id": "102087579",
                "wof:name": "San Francisco",
                "wof:placetype": "locality",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data"
            },
            "county": {
                "wof:id": 102087579,
                "wof:parent_id": "85688637",
                "wof:name": "San Francisco",
                "wof:placetype": "county",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data"
            },
            "region": {
                "wof:id": 85688637,
                "wof:parent_id": "85633793",
                "wof:name": "California",
                "wof:placetype": "region",
                "wof:country": "US",
                "wof:repo": "whosonfirst-data"
            }
        }
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.getInfo"></a>
#### mapzen.places.getInfo

Return a Who&#039;s On First record by ID.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `id` | A valid Who&#039;s On First ID. |  420561633 | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `513` | Unable to retrieve place |


##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getInfo&api_key=your-mapzen-api-key&id=420561633'

{
    "place": {
        "wof:id": 420561633,
        "wof:parent_id": "85865899",
        "wof:name": "Super Bowl City",
        "wof:placetype": "microhood",
        "wof:country": "US",
        "wof:repo": "whosonfirst-data"
    },
    "stat": "ok"
}
```

<a name="mapzen.places.getInfoMulti"></a>
#### mapzen.places.getInfoMulti

Return multiple Who&#039;s On First records by ID.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `ids` | A comma separated list of valid Who&#039;s On First ID. A maximum of 20 WOF IDs may be specified. |  101712565,101712563 | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;ids&#039; parameter |
| `433` | Maximum number of WOF IDs exceeded |
| `513` | Unable to retrieve places |


##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getInfoMulti&api_key=your-mapzen-api-key&ids=101712565,101712563'

{
    "places": [
        {
            "wof:id": 101712565,
            "wof:parent_id": "404525063",
            "wof:name": "Cleveland Heights",
            "wof:placetype": "locality",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 101712563,
            "wof:parent_id": "404523697",
            "wof:name": "Cleveland",
            "wof:placetype": "locality",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        }
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.getIntersects"></a>
#### mapzen.places.getIntersects

Return all the Who&#039;s On First places intersecting a bounding box.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `min_latitude` | A valid latitude coordinate, representing the bottom (Southern) edge of the bounding box. |  37.78807088 | yes |
| `min_longitude` | A valid longitude coordinate, representing the left (Western) edge of the bounding box. |  -122.34374508 | yes |
| `max_latitude` | A valid latitude coordinate, representing the top (Northern) edge of the bounding box. |  37.85749665 | yes |
| `max_longitude` | A valid longitude coordinate, representing the right (Eastern) edge of the bounding box. |  -122.25585446 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](pagination.md) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;min_latitude&#039; parameter |
| `433` | Missing &#039;min_longitude&#039; parameter |
| `434` | Missing &#039;max_latitude&#039; parameter |
| `435` | Missing &#039;max_longitude&#039; parameter |
| `436` | Invalid &#039;min_latitude&#039; parameter |
| `437` | Invalid &#039;min_longitude&#039; parameter |
| `438` | Invalid &#039;max_latitude&#039; parameter |
| `439` | Invalid &#039;max_longitude&#039; parameter |
| `513` | Failed to intersect |

##### Notes

* This API method uses [cursor-based](pagination.md#cursor) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getIntersects&api_key=your-mapzen-api-key&min_latitude=37.78807088&min_longitude=-122.34374508&max_latitude=37.85749665&max_longitude=-122.25585446&placetype=neighbourhood&per_page=1'

{
    "places": [
        {
            "wof:id": 1108785883,
            "wof:parent_id": 1108794093,
            "wof:name": "Broadway Auto Row",
            "wof:placetype": "neighbourhood",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        }
    ],
    "next_query": "method=mapzen.places.getIntersects&min_latitude=37.78807088&min_longitude=-122.34374508&max_latitude=37.85749665&max_longitude=-122.25585446&placetype=neighbourhood&per_page=1&cursor=1",
    "per_page": 1,
    "cursor": 1,
    "stat": "ok"
}
```

<a name="mapzen.places.getNearby"></a>
#### mapzen.places.getNearby

Return all the Who&#039;s On First records near a point.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `latitude` | A valid latitude coordinate. |  40.784165 | yes |
| `longitude` | A valid longitude coordinate. |  -73.958110 | yes |
| `radius` | A valid radius (in meters) to limit the query by. Default radius is 100. Maximum radius is 500. |  25 | no |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](pagination.md) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Invalid radius |
| `437` | Invalid placetype |
| `513` | Failed to get nearby |

##### Notes

* This API method uses [cursor-based](pagination.md#cursor) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getNearby&api_key=your-mapzen-api-key&latitude=40.784165&longitude=-73.958110&radius=25&placetype=neighbourhood&per_page=1'

{
    "places": [
        {
            "wof:id": 85865691,
            "wof:parent_id": 421205771,
            "wof:name": "Upper East Side",
            "wof:placetype": "neighbourhood",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        }
    ],
    "next_query": "method=mapzen.places.getNearby&latitude=40.784165&longitude=-73.958110&radius=25&placetype=neighbourhood&per_page=1&cursor=1",
    "per_page": 1,
    "cursor": 1,
    "stat": "ok"
}
```

<a name="mapzen.places.getParentByLatLon"></a>
#### mapzen.places.getParentByLatLon

Return Who&#039;s On First parent ID for a latitude and longitude and placetype

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `latitude` | A valid latitude coordinate. |  35.655065 | yes |
| `longitude` | A valid longitude coordinate. |  139.369640 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Missing &#039;placetype&#039; parameter |
| `437` | Invalid placetype |
| `513` | Failed to perform lookup |

##### Notes

* The inability to locate (or to disambiguate) a parent ID for a lat, lon will not trigger an API error. The following parent IDs may be returned by this API method: &#039;-1&#039; which means that a parent ID could not be identified or that there are multiple choices; or &#039;-3&#039; which means that the parent is a neighbourhood and their are multiple possible choices and you should go out for a beer and argue over which is the correct parent.
* The following output formats are **disallowed** for this API method: [meta](formats.md#meta)
* This API method is **experimental*. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getParentByLatLon&api_key=your-mapzen-api-key&latitude=35.655065&longitude=139.369640&placetype=neighbourhood'

{
    "place": {
        "wof:parent_id": null
    },
    "stat": "ok"
}
```

<a name="mapzen.places.getRandom"></a>
#### mapzen.places.getRandom

Return a random Who&#039;s On First record.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `513` | Unable to retrieve random place. |


##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getRandom&api_key=your-mapzen-api-key'

{
    "place": {
        "wof:id": 1125810213,
        "wof:parent_id": "85667945",
        "wof:name": "Bixessarri",
        "wof:placetype": "locality",
        "wof:country": "AD",
        "wof:repo": "whosonfirst-data"
    },
    "stat": "ok"
}
```

<a name="mapzen.places.search"></a>
#### mapzen.places.search

Query for Who&#039;s On First records.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `q` | Query for this value across all fields. |  poutine | no |
| `name` | Query for this value in the wof:name field. |  Gowanus Heights | no |
| `names` | Query for this value across all name related fields. |  SF | no |
| `alt` | Query for this value across all alternate name related fields (variant, colloquial, unknown). |  Paris | no |
| `preferred` | Query for this value across all preferred name related fields. |  বেইজিং | no |
| `variant` | Query for this value across all variant name related fields. |  💩 | no |
| `placetype` | Ensure records match this placetype. |  microhood | no |
| `exclude_placetype` | Ensure records exclude this placetype. |  venue | no |
| `tags` | Query for places with one or more of these tags. |  diner | no |
| `iso` | Ensure places belong to this (ISO) country code. |  CA | no |
| `country_id` | Ensure places belong to this country Who&#039;s On First ID. |  85633147 | no |
| `region_id` | Ensure places belong to this region Who&#039;s On First ID. |  85669831 | no |
| `locality_id` | Ensure places belong to this locality Who&#039;s On First ID. |  101736545 | no |
| `neighbourhood_id` | Ensure places belong to this neighbourhood Who&#039;s On First ID. |  102112179 | no |
| `brand_id` | Ensure places belong to this Who&#039;s On First brand ID. |  1126128733 | no |
| `concordance` | Query for places that have been concordified with this source. |  loc:id | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `has_brand` | Filter results to include only those places that have a Who&#039;s On First brand ID. Valid options are: 1, 0 |  1 | no |
| `exclude` | Exclude places matching these criteria. |  nullisland | no |
| `include` | Include places matching these criteria. |  deprecated | no |
| `min_lastmod` | Limit results to places that have been modified on or since this date (encoded as a Unix timestamp). |  1493855252 | no |
| `max_lastmod` | Limit results to places that have been modified on or before this date (encoded as a Unix timestamp). |  1496783757 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. | _cXVl...c7MDs=_ | no |
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](pagination.md) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid minimum lastmodified date |
| `433` | Invalid maximum lastmodified date |
| `434` | Impossible date range |
| `435` | Invalid placetype |
| `513` | Unable to perform search |

##### Notes

* This API method uses [mixed](pagination.md#mixed) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.search&api_key=your-mapzen-api-key&q=poutine&name=Gowanus Heights&names=SF&alt=Paris&preferred=বেইজিং&variant=💩&placetype=microhood&exclude_placetype=venue&tags=diner&category=&iso=CA&country_id=85633147&region_id=85669831&locality_id=101736545&neighbourhood_id=102112179&brand_id=1126128733&concordance=loc:id&is_current=1&is_ceased=1&is_deprecated=1&is_superseded=1&is_superseding=1&has_brand=1&exclude=nullisland&include=deprecated&min_lastmod=1493855252&max_lastmod=1496783757&per_page=1'

{
    "places": [

    ],
    "next_query": null,
    "total": 0,
    "page": 1,
    "per_page": 1,
    "pages": 0,
    "cursor": null,
    "stat": "ok"
}
```


### mapzen.places.pelias

* [mapzen.places.pelias.autocomplete](#mapzen.places.pelias.autocomplete)
* [mapzen.places.pelias.search](#mapzen.places.pelias.search)

<a name="mapzen.places.pelias.autocomplete"></a>
#### mapzen.places.pelias.autocomplete

Query Who&#039;s On First using the Pelias autocomplete API

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `text` | A valid query string. |  Gowanu | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* As of this writing this API method will return zero results by design. WOF does not currently support autocomplete and this method is necessary to keep the Mapzen.JS search widget happy.
* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.pelias.autocomplete&api_key=your-mapzen-api-key&text=Gowanu'

{
    "places": [
        {
            "wof:id": 85632643,
            "wof:parent_id": "102191573",
            "wof:name": "Democratic Republic of the Congo",
            "wof:placetype": "country",
            "wof:country": "CD",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 1126024693,
            "wof:parent_id": "102088069",
            "wof:name": "Mizhhir\u2019ya",
            "wof:placetype": "locality",
            "wof:country": "UA",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 101859789,
            "wof:parent_id": "102088069",
            "wof:name": "\u041c\u0456\u0436\u0433\u0456\u0440'\u044f",
            "wof:placetype": "locality",
            "wof:country": "UA",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 101752861,
            "wof:parent_id": "1108815855",
            "wof:name": "\u0414\u043d\u0456\u043f\u0440\u043e\u043f\u0435\u0442\u0440\u043e\u0432\u0441\u044c\u043a",
            "wof:placetype": "locality",
            "wof:country": "UA",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 101752847,
            "wof:parent_id": "1108815977",
            "wof:name": "\u041a\u0456\u0440\u043e\u0432\u043e\u0433\u0440\u0430\u0434",
            "wof:placetype": "locality",
            "wof:country": "UA",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 890460455,
            "wof:parent_id": "1108709503",
            "wof:name": "\u0130stanbul",
            "wof:placetype": "locality",
            "wof:country": "TR",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 1125842541,
            "wof:parent_id": "890461365",
            "wof:name": "\u015eanl\u0131urfa",
            "wof:placetype": "locality",
            "wof:country": "TR",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 101911225,
            "wof:parent_id": "890461365",
            "wof:name": "Sanliurfa",
            "wof:placetype": "locality",
            "wof:country": "TR",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 421186263,
            "wof:parent_id": "85680525",
            "wof:name": "Santiago Mari\u00f1o",
            "wof:placetype": "county",
            "wof:country": "VE",
            "wof:repo": "whosonfirst-data"
        },
        {
            "wof:id": 102016717,
            "wof:parent_id": "1108737197",
            "wof:name": "Gekhi",
            "wof:placetype": "locality",
            "wof:country": "RU",
            "wof:repo": "whosonfirst-data"
        }
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.pelias.search"></a>
#### mapzen.places.pelias.search

Query Who&#039;s On First using the Pelias API

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `text` | A valid query string. This is the equivalent of the WOF &#039;names&#039; parameter. |  JFK | no |
| `size` | The number of results per query. This is the equivalent of the WOF &#039;per_page&#039; parameter. |  10 | no |
| `layers` | Ensure records match this placetype. This is equivalent to the WOF &#039;placetype&#039; parameter. |  borough | no |
| `boundary.country` | Ensure places belong to this ISO country code. This is equivalent to the WOF &#039;iso&#039; parameter. |  ch | no |
| `q` | A valid query string. This is the equivalent of the Pelias &#039;text&#039; parameter. |  JFK | no |
| `placetype` | Ensure records match this placetype. This is equivalent to the Pelias &#039;layers&#039; parameter. |  neighbourhood | no |
| `iso` | Ensure places belong to this ISO country code. This is equivalent to the Pelias &#039;boundary.country&#039; parameter. |  fr | no |
| `query_field` | Scope the query alternate names (alt), variant names (variant), preferred names (preferred), wof:name values (name) or all the names (names). Valid options are: alt, name, names, preferred, variant. If left empty then the query will be performed across all WOF properties. |  alt | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. | _cXVl...c7MDs=_ | no |
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](pagination.md) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Unsupported Pelias API parameter |
| `433` | Multiple placetypes not supported (yet) |
| `434` | Invalid placetype |
| `435` | Invalid &#039;min_latitude&#039; parameter |
| `436` | Invalid &#039;max_longitude&#039; parameter |
| `437` | Invalid &#039;max_latitude&#039; parameter |
| `438` | Invalid &#039;max_longitude&#039; parameter |
| `439` | One or more missing parameters in bounding box query |
| `440` | Invalid output format |
| `441` | Invalid Pelias API version |
| `442` | Invalid (WOF) query field |
| `513` | Failed to perform lookup |

##### Notes

* Although neither the &#039;text&#039; or &#039;q&#039; parameters are required individually you must pass at least one of them.
* If both a Pelias API and its equivalent WOF parameter are passed the WOF parameter will take precendence. For example if you search for &#039;?text=JFK&amp;q=poutine&#039; the API will only search for &#039;poutine&#039;.
* The following Pelias API parameters are currently unsupported: boundary.circle.lat, boundary.circle.lon, boundary.circle.radius, boundary.rect.min_lat, boundary.rect.min_lon, boundary.rect.max_lat, boundary.rect.max_lon, focus.point.lat, focus.point.lon, sources
* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [meta](formats.md#meta)
* This API method uses [mixed](pagination.md#mixed) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.pelias.search&api_key=your-mapzen-api-key&text=JFK&size=10&layers=borough&boundary.rect.min_lat=25.84&boundary.rect.min_lon=-106.65&boundary.rect.max_lat=36.5&boundary.rect.max_lon=-93.51&boundary.country=ch&q=JFK&placetype=neighbourhood&iso=fr&min_latitude=25.84&min_longitude=-106.65&max_latitude=36.5&max_longitude=-93.51&query_field=alt&per_page=1'

{
    "places": [

    ],
    "next_query": null,
    "total": 0,
    "page": 1,
    "per_page": 1,
    "pages": 0,
    "cursor": null,
    "stat": "ok"
}
```


### mapzen.places.placetypes

* [mapzen.places.placetypes.getInfo](#mapzen.places.placetypes.getInfo)
* [mapzen.places.placetypes.getList](#mapzen.places.placetypes.getList)
* [mapzen.places.placetypes.getRoles](#mapzen.places.placetypes.getRoles)

<a name="mapzen.places.placetypes.getInfo"></a>
#### mapzen.places.placetypes.getInfo

Return details for a Who&#039;s On First placetype.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `id` | A valid Who&#039;s On First placetype ID. |  102322043 | no |
| `name` | A valid Who&#039;s On First placetype name. |  disputed | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid place ID |
| `433` | Invalid place name |

##### Notes

* Although the &quot;id&quot; and &quot;name&quot; parameters are each marked as optional, you need to pass at least one of them. The order of precedence is &quot;id&quot; followed by &quot;name&quot;.
* The following output formats are **disallowed** for this API method: [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.placetypes.getInfo&api_key=your-mapzen-api-key&id=102322043&name=disputed'

{
    "placetype": {
        "id": 102322043,
        "name": "disputed",
        "parents": [
            "country"
        ],
        "role": "common_optional"
    },
    "stat": "ok"
}
```

<a name="mapzen.places.placetypes.getList"></a>
#### mapzen.places.placetypes.getList

Return a list of Who&#039;s On First placetypes.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `role` | Only return placetypes that are part of this role. |  common | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid role |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.placetypes.getList&api_key=your-mapzen-api-key&role=common'

{
    "placetypes": [
        {
            "id": 102312307,
            "name": "country",
            "parents": [
                "continent",
                "empire"
            ],
            "role": "common"
        },
        {
            "id": 102312309,
            "name": "continent",
            "parents": [
                "planet"
            ],
            "role": "common"
        },
        {
            "id": 102312311,
            "name": "region",
            "parents": [
                "macroregion",
                "dependency",
                "disputed",
                "country"
            ],
            "role": "common"
        },
        {
            "id": 102312317,
            "name": "locality",
            "parents": [
                "localadmin",
                "county",
                "region"
            ],
            "role": "common"
        },
        {
            "id": 102312319,
            "name": "neighbourhood",
            "parents": [
                "macrohood",
                "borough",
                "locality"
            ],
            "role": "common"
        },
        {
            "id": 102312319,
            "name": "neighborhood",
            "parents": [
                "macrohood",
                "borough",
                "locality"
            ],
            "role": "common"
        }
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.placetypes.getRoles"></a>
#### mapzen.places.placetypes.getRoles

Return a list of Who&#039;s On First placetype roles.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.placetypes.getRoles&api_key=your-mapzen-api-key'

{
    "roles": [
        "optional",
        "common_optional",
        "common"
    ],
    "stat": "ok"
}
```


### mapzen.places.repos

* [mapzen.places.repos.getByLatLon](#mapzen.places.repos.getByLatLon)

<a name="mapzen.places.repos.getByLatLon"></a>
#### mapzen.places.repos.getByLatLon

Return a Who&#039;s On First repo name for a latitude and longitude.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `latitude` | A valid latitude coordinate. |  37.766633 | yes |
| `longitude` | A valid longitude coordinate. |  -122.417693 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. Valid options are: -1, 1, 0 |  1 | no |
| `is_ceased` | Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0 |  1 | no |
| `is_deprecated` | Filter results to include only those places that have a valid EDTF deprecated date or not. Valid options are: 1, 0 |  1 | no |
| `is_superseded` | Filter results to include only those places that have (or have not) been superseded. Valid options are: 1, 0 |  1 | no |
| `is_superseding` | Filter results to include only those places that have (or have not) superseded other places. Valid options are: 1, 0 |  1 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Missing &#039;placetype&#039; parameter |
| `437` | Invalid placetype |
| `513` | Failed to perform point-in-polygon lookup |
| `514` | Failed to locate any places |
| `515` | Too many places to choose from. |
| `516` | Missing iso:country property! |
| `517` | Missing unlc:subdivision property! |
| `518` | Invalid unlc:subdivision property. |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.repos.getByLatLon&api_key=your-mapzen-api-key&latitude=37.766633&longitude=-122.417693&placetype=neighbourhood&is_current=1&is_ceased=1&is_deprecated=1&is_superseded=1&is_superseding=1'

{
    "repo": "whosonfirst-data",
    "url": "https:\/\/github.com\/whosonfirst-data\/whosonfirst-data",
    "stat": "ok"
}
```


### mapzen.places.sources

* [mapzen.places.sources.getInfo](#mapzen.places.sources.getInfo)
* [mapzen.places.sources.getList](#mapzen.places.sources.getList)
* [mapzen.places.sources.getPrefixes](#mapzen.places.sources.getPrefixes)

<a name="mapzen.places.sources.getInfo"></a>
#### mapzen.places.sources.getInfo

Return details for a Who&#039;s On First source.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `id` | A valid Who&#039;s On First source ID. |  840464301 | no |
| `prefix` | A valid Who&#039;s On First source prefix. |  loc | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid source ID |
| `433` | Invalid source prefix |

##### Notes

* Although the &quot;id&quot; and &quot;prefix&quot; parameters are each marked as optional, you need to pass at least one of them. The order of precedence is &quot;id&quot; followed by &quot;prefix&quot;.
* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.sources.getInfo&api_key=your-mapzen-api-key&id=ID&prefix=PREFIX'
```

<a name="mapzen.places.sources.getList"></a>
#### mapzen.places.sources.getList

Return the list of Who&#039;s On First sources.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.sources.getList&api_key=your-mapzen-api-key'

{
    "sources": [
        {
            "description": "A search-and-discovery service that compiles a database of locations and places worldwide.",
            "fullname": "Foursquare",
            "id": 857075439,
            "key": "id",
            "license": "https:\/\/foursquare.com\/legal\/terms",
            "license_text": "Subject to these Terms of Use, Foursquare grants each user of the Site and\/or Service a worldwide, non-exclusive, non-sublicensable and non-transferable license to use, modify and reproduce the Content, solely for personal, non-commercial use.",
            "license_type": "CC BY",
            "name": "foursquare",
            "prefix": "4sq",
            "url": "http:\/\/www.foursquare.com"
        },
        {
            "description": "Official GIS Data for Alameda County, CA.",
            "fullname": "Alameda County Data Sharing Initiative",
            "id": 874397693,
            "key": "",
            "license": "https:\/\/data.acgov.org\/terms-of-use",
            "license_text": "You understand and agree that Your use of the Data is at Your sole risk. The Data is made available on an 'as is' and 'as available' basis without any warranties of any kind, whether express or implied, including without limitation implied warranties of merchantability, fitness for a particular purpose, and non-infringement. Should there be an error, inaccuracy, or other defect in the Data, You assume the full cost of correcting any such error, inaccuracy or defect.",
            "license_type": "Public Domain",
            "name": "acgov",
            "prefix": "acgov",
            "url": "https:\/\/data.acgov.org\/"
        },
        {
            "description": "Purveyors of fine freeware since 1972. On the net since 1991.",
            "fullname": "Acme Laboratories",
            "id": 1108961115,
            "key": "id",
            "license": "https:\/\/acme.com\/license.html",
            "license_text": "Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met: 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer. 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and\/or other materials provided with the distribution.",
            "license_type": "BSD (modified)",
            "name": "acme",
            "prefix": "acme",
            "url": "https:\/\/acme.com\/"
        },
        {
            "description": "Property prefix.",
            "fullname": "addr",
            "id": 1108832191,
            "key": "id",
            "license": "N\/A",
            "license_text": "",
            "license_type": "N\/A",
            "name": "addr",
            "prefix": "addr",
            "url": ""
        },
        {
            "description": "Layers are viewable from the link in the url field as Buurten (microhoods), Buurtcombinaties (neighbourhoods), and Stadsdelen en Haven (boroughs). Open source information as well as downloadable datasets are available from the link in the license field.",
            "fullname": "Amsterdam Open Datakaart",
            "id": 1108802967,
            "key": "",
            "license": "https:\/\/kaart.amsterdam.nl\/datasets",
            "license_text": "N\/A",
            "license_type": "CC BY (assumed)",
            "name": "amsgis",
            "prefix": "amsgis",
            "url": "https:\/\/kaart.amsterdam.nl"
        },
        {
            "description": "Open Data portal for the City of Buenos Aires, Argentina.",
            "fullname": "Ciudad Aut\u00f3noma de Buenos Aires, Iniciativa de Datos P\u00fablicos y Transparencia",
            "id": 1108969549,
            "key": "",
            "license": "https:\/\/data.buenosaires.gob.ar\/tyc",
            "license_text": "La reutilizaci\u00f3n autorizada puede incluir la copia, difusi\u00f3n, modificaci\u00f3n, adaptaci\u00f3n, extracci\u00f3n, reordenamiento y combinaci\u00f3n de la informaci\u00f3n contenida en el sitio ... Debe citarse la fuente de los documentos objeto de la reutilizaci\u00f3n.",
            "license_type": "CC BY",
            "name": "arg-caba",
            "prefix": "arg-caba",
            "url": "https:\/\/data.buenosaires.gob.ar\/dataset\/barrios"
        },
        {
            "description": "",
            "fullname": "data.gv.at",
            "id": 823312445,
            "key": "",
            "license": "http:\/\/creativecommons.org\/licenses\/by\/3.0\/at\/",
            "license_text": "You are free to Share, copy and redistribute the material in any medium or format. Adapt, remix, transform, and build upon the material for any purpose, even commercially. The licensor cannot revoke these freedoms as long as you follow the license terms.",
            "license_type": "CC BY 3.0",
            "name": "atgov",
            "prefix": "atgov",
            "url": "https:\/\/www.data.gv.at"
        },
        {
            "description": "Neighborhoods within the City of Atlanta.",
            "fullname": "Atlanta Department of Planning and Community Development",
            "id": 1108797031,
            "key": "",
            "license": "https:\/\/www.arcgis.com\/home\/item.html?id=716f417a1990446389ef7fd2c381d09f",
            "license_text": "Share, copy and redistribute the material in any medium or format. Adapt, remix, transform, and build upon the material for any purpose, even commercially.",
            "license_type": "CC BY 4.0",
            "name": "atldpcd",
            "prefix": "atldpcd",
            "url": "http:\/\/dpcd.coaplangis.opendata.arcgis.com\/datasets\/neighborhoods"
        },
        {
            "description": "The ABS is Australia's national statistical agency, providing trusted official statistics on a wide range of economic, social, population and environmental matters of importance to Australia.",
            "fullname": "Australian Bureau of Statistics",
            "id": 1108693461,
            "key": "",
            "license": "http:\/\/www.abs.gov.au\/websitedbs\/D3310114.nsf\/Home\/%A9+Copyright?opendocument",
            "license_text": "Unless otherwise noted, all material on this website, except the ABS logo, the Commonwealth Coat of Arms, and any material protected by a trade mark, is licensed under a Creative Commons Attribution 2.5 Australia licence.",
            "license_type": "CC BY 2.5 AU",
            "name": "ausstat",
            "prefix": "ausstat",
            "url": "http:\/\/www.abs.gov.au\/AUSSTATS\/abs@.nsf\/DetailsPage\/1270.0.55.003July%202011?OpenDocument"
        },
        {
            "description": "",
            "fullname": "Austria Open Data",
            "id": 1108839435,
            "key": "id",
            "license": "http:\/\/creativecommons.org\/licenses\/by\/3.0\/at\/",
            "license_text": "The data in our catalog are freely available under CC BY 3.0 or CC0 license. The catalog can be sorted according to topic areas. The exact data guidelines can be found in the individual data sets.",
            "license_type": "CC BY 3.0",
            "name": "Austria Open Data",
            "prefix": "austriaod",
            "url": "https:\/\/www.data.gv.at\/katalog\/dataset\/c33d36b0-f184-4f2a-89cc-839ca7fcf88a"
        },
        {
            "description": "Azavea is a civic technology firm based in Philadelphia. Azavea applies geospatial technology for civic and social impact.",
            "fullname": "Azavea, Inc.",
            "id": 1108721357,
            "key": "",
            "license": "https:\/\/www.opendataphilly.org\/dataset\/philadelphia-neighborhoods",
            "license_text": "You are free to: Share, copy and redistribute the material in any medium or format. Adapt, remix, transform, and build upon the material for any purpose, even commercially.",
            "license_type": "CC BY 3.0 US",
            "name": "azavea",
            "prefix": "azavea",
            "url": "https:\/\/www.opendataphilly.org\/dataset\/philadelphia-neighborhoods\/resource\/06e8d380-821f-44ce-8718-a0f2f7902318"
        },
        {
            "description": "City of Baltimore Open Data Portal. This website is operated by the Mayor and City Council of Baltimore (the 'City') and the data is provided as a service to the public.",
            "fullname": "Baltimore Mayor's Office of Information Technology",
            "id": 1108794385,
            "key": "",
            "license": "https:\/\/data.baltimorecity.gov\/Geographic\/Baltimore-Study-Area\/cdrh-gpzc\/about",
            "license_text": "THE WORK (AS DEFINED BELOW) IS PROVIDED UNDER THE TERMS OF THIS CREATIVE COMMONS PUBLIC LICENSE ('CCPL' OR 'LICENSE'). THE WORK IS PROTECTED BY COPYRIGHT AND\/OR OTHER APPLICABLE LAW.",
            "license_type": "Attribution 3.0 Unported",
            "name": "baltomoit",
            "prefix": "baltomoit",
            "url": "https:\/\/data.baltimorecity.gov\/Geographic\/Baltimore-Study-Area\/cdrh-gpzc"
        },
        {
            "description": "Geopunt is the central Flesmish gateway to geographic government information. The geoportal makes geographical information accessible to government agencies, citizens, organizations and companies.",
            "fullname": "Voorlopig Referentiebestand Gemeentegrenzen",
            "id": 857004783,
            "key": "id",
            "license": "http:\/\/www.geopunt.be\/nl\/over-geopunt\/disclaimer",
            "license_text": "The licensee is given the non-exclusive, worldwide right to reuse the product for each legitimate purpose, including reproducing, transmitting, publishing, adapting and commercial exploitation of the product.",
            "license_type": "Free Open Data License Flanders v1.0",
            "name": "begov",
            "prefix": "begov",
            "url": "http:\/\/www.geopunt.be\/download?container=referentiebestand-gemeenten&title=Voorlopig%20referentiebestand%20gemeentegrenzen"
        },
        {
            "description": "Burrito Justice - La Lengua, San Francisco, CA.",
            "fullname": "Burrito Justice",
            "id": 404734205,
            "key": "id",
            "license": "http:\/\/burritojustice.com",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "burritojustice",
            "prefix": "bj",
            "url": "http:\/\/burritojustice.com\/la-lengua\/"
        },
        {
            "description": "Neighborhood boundaries are created based on zip code, zoning district boundaries and census tract boundaries. This GIS data layer was produced by the BRA Office of Digital Cartography and GIS.",
            "fullname": "Boston Redevelopment Authority",
            "id": 1108694665,
            "key": "",
            "license": "https:\/\/data.cityofboston.gov\/City-Services\/Boston-Neighborhood-Shapefiles\/af56-j7tb",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "bra",
            "prefix": "bra",
            "url": "https:\/\/data.cityofboston.gov\/"
        },
        {
            "description": "Crowdsourced by the locals: http:\/\/geosprocket.blogspot.com\/2012\/10\/results-of-burlington-neighborhoods.html",
            "fullname": "Burlington VT Neighborhoods Project",
            "id": 404734212,
            "key": "id",
            "license": "http:\/\/geosprocket.blogspot.com\/2012\/10\/results-of-burlington-neighborhoods.html",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0 (equivalent)",
            "name": "btvneighborhoods",
            "prefix": "btv",
            "url": "https:\/\/gist.github.com\/wboykinm\/dfe44481d8ff759c4f1afea223a7c070"
        },
        {
            "description": "Neighbourhood data for the City of Cambrige, MA.",
            "fullname": "City of Cambridge Geographic Information System Department",
            "id": 1108713437,
            "key": "",
            "license": "https:\/\/data.cambridgema.gov\/download\/tif9-pmiw\/application\/pdf",
            "license_text": "Any user of Data distributed by the City may modify, use and publish such Data without charge.",
            "license_type": "CC BY",
            "name": "camgov",
            "prefix": "camgov",
            "url": "http:\/\/www.cambridgema.gov\/GIS\/gisdatadictionary\/Boundary\/BOUNDARY_CDDNeighborhoods"
        },
        {
            "description": "Open municipal boundary data provided by the Alberta Open Government program.",
            "fullname": "Alberta Open Government - Municipal Boundaries",
            "id": 1108974149,
            "key": "",
            "license": "https:\/\/open.alberta.ca\/documentation\/ogp-licence",
            "license_text": "Copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose...Acknowledge the source of the Information by including any attribution statement specified by the Information Provider(s) and, where possible, provide a link to this licence...",
            "license_type": "Open Government Licence - Alberta",
            "name": "can-abog",
            "prefix": "can-abog",
            "url": "https:\/\/open.alberta.ca\/opendata\/property-municipal-boundaries"
        },
        {
            "description": "Open Data Portal for Burnaby, B.C.",
            "fullname": "City of Burnaby GIS Department",
            "id": 1108914995,
            "key": "",
            "license": "https:\/\/www.burnaby.ca\/opendata\/licence.html",
            "license_text": "you are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "Open Government License - British Columbia, v2.0",
            "name": "can-bbygov",
            "prefix": "can-bbygov",
            "url": "http:\/\/data.burnaby.ca\/datasets\/0023da089ff746bfb688e2531d1f2beb_9"
        },
        {
            "description": "Community boundary data generated by the City of Calgary Department of Corporate Analytics and Innovation for use in community planning.",
            "fullname": "City of Calgary, Corporate Analytics and Innovation",
            "id": 1108963891,
            "key": "",
            "license": "https:\/\/data.calgary.ca\/stories\/s\/u45n-7awa",
            "license_text": "Copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose...Acknowledge the source of the Information by including any attribution statement specified by the Information Provider(s) and, where possible, provide a link to this license.",
            "license_type": "Open Government Licence - City of Calgary",
            "name": "can-calcai",
            "prefix": "can-calcai",
            "url": "https:\/\/data.calgary.ca\/Base-Maps\/Community-Boundaries\/ab7m-fwn6"
        },
        {
            "description": "Open Data Portal for the District of North Vancouver.",
            "fullname": "District of North Vancouver Government",
            "id": 1108906765,
            "key": "",
            "license": "http:\/\/geoweb.dnv.org\/data\/metadata.php?dataset=RegNeighbourhood",
            "license_text": "you are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "Open Government Licence - British Columbia, v2.0",
            "name": "can-dnvgov",
            "prefix": "can-dnvgov",
            "url": "http:\/\/geoweb.dnv.org\/Products\/Data\/SHP\/RegNeighbourhood_shp.zip"
        },
        {
            "description": "Neighbourhood\/Ward data provided by the City of Edmonton Department of Sustainable Development.",
            "fullname": "City of Edmonton Department of Sustainable Development",
            "id": 1108970467,
            "key": "",
            "license": "https:\/\/www.edmonton.ca\/city_government\/documents\/Web-version2.1-OpenDataAgreement.pdf",
            "license_text": "The City of Edmonton (the City) grants you a worldwide, royalty-free, non-exclusive licence to use, modify, and distribute the datasets in all current and future media and formats for any lawful purpose, including for commercial purposes. You are free to copy, modify, publish, translate, adapt, distribute or otherwise use the datasets in any medium, mode or format for any lawful purpose.",
            "license_type": "Open Government Licence - Edmonton",
            "name": "can-edmdsd",
            "prefix": "can-edmdsd",
            "url": "https:\/\/data.edmonton.ca\/Geospatial-Boundaries\/City-of-Edmonton-Neighbourhood-Boundaries-with-War\/jfvj-x253"
        },
        {
            "description": "Community portrait data created by the city of Gatineau for use in planning and sustainable development (Data provided by request from <infoterritoire@gatineau.ca>).",
            "fullname": "Gatineau Service de l'urbanisme et du developpement durable (SUDD)",
            "id": 1126109975,
            "key": "",
            "license": "http:\/\/www3.gatineau.ca\/Infoterritoire\/WebInterface\/help\/fr\/Content\/1_About\/1_About_FR.htm",
            "license_text": "Confirmed open source availability by Maurin Dabbadie of the Gatineau Department of Planning and Sustainable Development on 2017-06-07 <dabbadie.maurin@gatineau.ca>.",
            "license_type": "CC BY (equivalent)",
            "name": "can-gatsudd",
            "prefix": "can-gatsudd",
            "url": "http:\/\/www3.gatineau.ca\/Infoterritoire\/WebInterface\/views\/index.aspx"
        },
        {
            "description": "The collaborative crossroads in Quebec open data.",
            "fullname": "Laval Service de l'urbanisme",
            "id": 1108960971,
            "key": "",
            "license": "https:\/\/www.donneesquebec.ca\/fr\/licence\/#cc-by",
            "license_text": "This license allows other people to distribute, remix, arrange and adapt your work, even for commercial purposes, as long as you are credited with the original creation by quoting your name.",
            "license_type": "CC BY",
            "name": "can-lvlsu",
            "prefix": "can-lvlsu",
            "url": "https:\/\/www.donneesquebec.ca\/recherche\/fr\/dataset\/limites-des-anciennes-municipalites"
        },
        {
            "description": "Open Data portal for the Ville de Montreal.",
            "fullname": "Montreal Service de la Mise en Valeur du Territoire",
            "id": 1108906761,
            "key": "",
            "license": "https:\/\/creativecommons.org\/licenses\/by\/4.0\/",
            "license_text": "You are free to Share, copy and redistribute the material in any medium or format and Adapt, remix, transform, and build upon the material for any purpose, even commercially. ",
            "license_type": "CC BY 4.0",
            "name": "can-mtlsmvt",
            "prefix": "can-mtlsmvt",
            "url": "http:\/\/donnees.ville.montreal.qc.ca\/dataset\/quartiers"
        },
        {
            "description": "Open Data portal for the City of New Westminster, BC.",
            "fullname": "City of New Westminster Development Services Department",
            "id": 1108916059,
            "key": "",
            "license": "http:\/\/opendata.newwestcity.ca\/licence",
            "license_text": "You are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "OGL - City of New Westminster",
            "name": "can-nwds",
            "prefix": "can-nwds",
            "url": "http:\/\/opendata.newwestcity.ca\/datasets\/neighbourhoods"
        },
        {
            "description": "Custom neighbourhood data provided by the Ottawa Neighbourhood Study organization for community enrichment.",
            "fullname": "Ottawa Neighbourhood Study (ONS)",
            "id": 1108973847,
            "key": "",
            "license": "http:\/\/neighbourhoodstudy.ca\/ons-terms-of-use\/",
            "license_text": "....publicly available and accessible data...must give ONS credit for each use or reproduction of the datasets...",
            "license_type": "CC BY (equivalent)",
            "name": "can-ons",
            "prefix": "can-ons",
            "url": "Data provided by request at http:\/\/neighbourhoodstudy.ca\/contact\/"
        },
        {
            "description": "Neighbourhood (district) data provided by Quebec City.",
            "fullname": "Quebec City Open Data Portal",
            "id": 1126115707,
            "key": "",
            "license": "http:\/\/donnees.ville.quebec.qc.ca\/licence.aspx",
            "license_text": "...copy and redistribute the material in any medium or format...remix, transform, and build upon the material for any purpose, even commercially...You must give appropriate credit, provide a link to the license, and indicate if changes were made.",
            "license_type": "CC BY 4.0",
            "name": "can-qcodp",
            "prefix": "can-qcodp",
            "url": "http:\/\/donnees.ville.quebec.qc.ca\/donne_details.aspx?jdid=9"
        },
        {
            "description": "Boundaries provided by the City of Regina to delineate community associations.",
            "fullname": "City of Regina Open Data - Community Associations",
            "id": 1126113619,
            "key": "",
            "license": "http:\/\/www.regina.ca\/residents\/open-government\/open-government-licence\/",
            "license_text": "Copy, modify, publish, translate, adapt, distribute or otherwise use the data sets in any medium, mode or format for any lawful purpose... Acknowledge the source of the Information by including any attribution statement specified by the Information Provider and, where possible, provide a link to this licence.",
            "license_type": "Open Government Licence - City of Regina",
            "name": "can-rodca",
            "prefix": "can-rodca",
            "url": "http:\/\/open.regina.ca\/dataset\/community-associations"
        },
        {
            "description": "Neighbourhood regions provided by the city of Saskatoon, used for demographic purposes.",
            "fullname": "City of Saskatoon Open Data Portal - Neighbourhood Areas",
            "id": 1126113989,
            "key": "",
            "license": "http:\/\/opendata-saskatoon.cloudapp.net\/TermsOfUse\/TermsOfUse",
            "license_text": "...a broad license to use the currently published data on the City of Saskatoon website (\u201cInformation\u201d) for your own analysis and applications...appreciate credit for provision of the Information, this is not a strict requirement.",
            "license_type": "CC0 (equivalent)",
            "name": "can-saskodp",
            "prefix": "can-saskodp",
            "url": "http:\/\/opendata-saskatoon.cloudapp.net\/DataBrowser\/SaskatoonOpenDataCatalogueBeta\/NeighbourhoodArea#param=NOFILTER--DataView--Results"
        },
        {
            "description": "Open data portal for the City of Surrey, BC.",
            "fullname": "City of Surrey GIS Section",
            "id": 1108951549,
            "key": "",
            "license": "http:\/\/data.surrey.ca\/pages\/open-government-licence-surrey",
            "license_text": "You are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "OGL - City of Surrey",
            "name": "can-surgis",
            "prefix": "can-surgis",
            "url": "https:\/\/data.surrey.ca\/dataset\/surrey-city-boundary"
        },
        {
            "description": "Neighbourhood boundary data provided by the City of Victoria Open Data Catalogue.",
            "fullname": "City of Victoria Open Data Catalogue",
            "id": 1126129879,
            "key": "",
            "license": "http:\/\/www.victoria.ca\/EN\/main\/online-services\/open-data-catalogue\/open-data-licence.html",
            "license_text": "Copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose...Acknowledge the source of the Information by including any attribution statement specified by the Information Provider and, where possible, provide a link to this licence.",
            "license_type": "Open Government Licence - City of Victoria",
            "name": "can-vicodc",
            "prefix": "can-vicodc",
            "url": "http:\/\/www.victoria.ca\/EN\/main\/online-services\/open-data-catalogue.html"
        },
        {
            "description": "Neighbourhood planning districts provided by the City of Winnipeg on their open data portal.",
            "fullname": "City of Winnipeg Department of Planning, Property, and Development",
            "id": 1108968171,
            "key": "",
            "license": "https:\/\/data.winnipeg.ca\/open-data-licence",
            "license_text": "Copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose...Acknowledge the source of the Information by including any attribution statement specified by the Information Provider(s) and, where possible, provide a link to this licence.",
            "license_type": "Open Government License - Winnipeg",
            "name": "can-wpgppd",
            "prefix": "can-wpgppd",
            "url": "https:\/\/data.winnipeg.ca\/City-Planning\/Neighbourhood\/fen6-iygi"
        },
        {
            "description": "Datasets can be found under the shapefile or geodatabase directories, sorted by precision and location.",
            "fullname": "Natural Resources Canada, CanVec Hydrographic Features",
            "id": 1108962077,
            "key": "",
            "license": "http:\/\/open.canada.ca\/en\/open-government-licence-canada",
            "license_text": "You are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "Open Government Licence - Canada",
            "name": "canvec-hydro",
            "prefix": "canvec-hydro",
            "url": "http:\/\/open.canada.ca\/data\/en\/dataset\/9d96e8c9-22fe-4ad2-b5e8-94a6991b744b"
        },
        {
            "description": "This data portal consists of a register containing information about and references to data sets by Dutch authorities.",
            "fullname": "Centraal Bureau voor de Statistiek",
            "id": 1108804789,
            "key": "",
            "license": "https:\/\/data.overheid.nl\/data\/dataset\/wijk-en-buurtkaart-2016-versie-1",
            "license_text": "With this license, a re-user is free to share, copy, distribute and transmit the dataset through any medium or file format. The dataset may be edited and may be used for commercial purposes. A reference to the creator of the data is required.",
            "license_type": "CC BY 3.0",
            "name": "cbsnl",
            "prefix": "cbsnl",
            "url": "https:\/\/data.overheid.nl\/data\/dataset\/wijk-en-buurtkaart-2016-versie-1\/resource\/7f32452a-f035-4a23-bce9-1972f5189beb"
        },
        {
            "description": "The Geoportal of the Swiss Federation.",
            "fullname": "Swiss Confederation",
            "id": 772975927,
            "key": "",
            "license": "http:\/\/data.geo.admin.ch\/ch.swisstopo-vd.ortschaftenverzeichnis_plz\/",
            "license_text": "The information contained on the websites of the Federal Authorities is made available to the public.",
            "license_type": "CC0",
            "name": "chgov",
            "prefix": "chgov",
            "url": "http:\/\/data.geo.admin.ch"
        },
        {
            "description": "A directory of business listings in London.",
            "fullname": "City of London Companies House",
            "id": 1158784151,
            "key": "number",
            "license": "https:\/\/data.london.gov.uk\/about\/terms-and-conditions\/",
            "license_text": "May use the data contained in this site for any purpose, providing it does not infringe the terms and conditions.",
            "license_type": "CC0",
            "name": "companieshouse",
            "prefix": "companieshouse",
            "url": "https:\/\/data.london.gov.uk\/dataset\/directory-of-london-businesses"
        },
        {
            "description": "Towards a Public Data Infrastructure for a Large, Multilingual, Semantic Knowledge Graph.",
            "fullname": "DBpedia",
            "id": 840464281,
            "key": "id",
            "license": "http:\/\/en.wikipedia.org\/wiki\/Wikipedia:Text_of_Creative_Commons_Attribution-ShareAlike_3.0_Unported_License",
            "license_text": "You are free to Share, to copy, distribute and transmit the work, and to Remix, to adapt the work for any purpose, even commercially.",
            "license_type": "CC BY-SA 3.0 Unported License",
            "name": "dbpedia",
            "prefix": "dbp",
            "url": "http:\/\/dbpedia.org\/"
        },
        {
            "description": "Open Data portal for the City of Denver, CO.",
            "fullname": "Denver Department of Community Planning and Development",
            "id": 1108748977,
            "key": "",
            "license": "https:\/\/www.denvergov.org\/opendata\/termsofuse",
            "license_text": "You are free to: Share, copy and redistribute the material in any medium or format. Adapt, remix, transform, and build upon the material for any purpose, even commercially. The licensor cannot revoke these freedoms as long as you follow the license terms.",
            "license_type": "CC BY 3.0",
            "name": "denvercpd",
            "prefix": "denvercpd",
            "url": "https:\/\/www.denvergov.org\/opendata\/dataset\/city-and-county-of-denver-statistical-neighborhoods"
        },
        {
            "description": "In most places that allow direct-dialed international calls, you must first dial an international access code. These access codes are maintained for the member countries or regions by the International Telecommunication Union (ITU).",
            "fullname": "Dial Codes",
            "id": 1158832839,
            "key": "",
            "license": "https:\/\/www.itu.int\/en\/Pages\/copyright.aspx",
            "license_text": "ITU holds copyright in the information available on this Web site, unless otherwise stated. Copyright in any third-party materials found on this Web site must also be respected.",
            "license_type": "Restricted",
            "name": "dial",
            "prefix": "dial",
            "url": "https:\/\/www.itu.int\/itudoc\/itu-t\/ob-lists\/icc\/e164_763.html"
        },
        {
            "description": "These codes are provided for by Article 20 of the Convention on Road Traffic (Geneva, 1949). Therein, they are called 'distinguishing signs of the place of registration' of vehicles.",
            "fullname": "Distinguishing Signs - United Nations Economic Commission for Europe",
            "id": 1158832831,
            "key": "",
            "license": "http:\/\/www.unece.org\/legal_notice\/copyrightnotice.html",
            "license_text": "All rights reserved.",
            "license_type": "Restricted",
            "name": "ds",
            "prefix": "ds",
            "url": "https:\/\/www.unece.org\/trans\/roadsafe\/distinguishing_signs.html"
        },
        {
            "description": "Elections BC is an independent and non-partisan Office of the Legislature, British Colombia.",
            "fullname": "Elections BC",
            "id": 1108962955,
            "key": "id",
            "license": "http:\/\/142.34.128.33\/docs\/EBC-Open-Data-Licence.pdf",
            "license_text": "You are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose",
            "license_type": "Elections BC Open Data Licence",
            "name": "ebc",
            "prefix": "ebc",
            "url": "http:\/\/elections.bc.ca\/"
        },
        {
            "description": "Property prefix. This website describes the current effort to develop a reasonably comprehensive date\/time definition for the bibliographic community, as well as other interested communities, and submitting it for standardization or some other mode of formalization, for example a W3C note or an amendment to ISO 8601.",
            "fullname": "Extended Date\/Time Format",
            "id": 404734173,
            "key": "",
            "license": "https:\/\/www.loc.gov\/legal\/",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0 1.0 Universal",
            "name": "edtf",
            "prefix": "edtf",
            "url": "http:\/\/loc.gov\/standards\/datetime\/"
        },
        {
            "description": "Neighbourhood and district data provided by the City of Madrid.",
            "fullname": "Portal de datos abiertos del Ayuntamiento de Madrid",
            "id": 1158844927,
            "key": "",
            "license": "http:\/\/datos.madrid.es\/egob\/catalogo\/aviso-legal",
            "license_text": "Las condiciones generales permiten la reutilizaci\u00f3n de los documentos para fines comerciales y no comerciales. Se entiende por reutilizaci\u00f3n el uso de documentos que obran en poder del Ayuntamiento de Madrid, siempre que dicho uso no constituya una actividad administrativa p\u00fablica.",
            "license_type": "CC0 (equivalent)",
            "name": "esp-aytomad",
            "prefix": "esp-aytomad",
            "url": "http:\/\/datos.madrid.es\/portal\/site\/egob\/menuitem.c05c1f754a33a9fbe4b2e4b284f1a5a0\/?vgnextoid=46b55cde99be2410VgnVCM1000000b205a0aRCRD&vgnextchannel=374512b9ace9f310VgnVCM100000171f5a0aRCRD&vgnextfmt=default"
        },
        {
            "description": "Neighbourhood (district) data as provided by the Barcelona City Council (CartoBCN).",
            "fullname": "CartoBCN",
            "id": 1158844413,
            "key": "",
            "license": "http:\/\/w133.bcn.cat\/geoportal\/descargas\/en_gb_cond_us_carto.pdf",
            "license_text": "...their use for commercial and non-commercial purposes...their modification, transformation and adaptation...so long as reference is made to Barcelona City Council's authorship...",
            "license_type": "CC BY",
            "name": "esp-cartobcn",
            "prefix": "esp-cartobcn",
            "url": "http:\/\/w20.bcn.cat\/cartobcn\/"
        },
        {
            "description": "Homepage for the Federal Aviation Administration.",
            "fullname": "Federal Aviation Administration",
            "id": 840464293,
            "key": "code",
            "license": "https:\/\/www.usa.gov\/government-works",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0 1.0 Universal",
            "name": "faa",
            "prefix": "faa",
            "url": "http:\/\/www.faa.gov\/"
        },
        {
            "description": "Freebase was a large collaborative knowledge base consisting of data composed mainly by its community members. It was an online collection of structured data harvested from many sources, including individual, user-submitted wiki contributions. See also: http:\/\/creativecommons.org\/licenses\/by\/2.5\/.",
            "fullname": "Freebase",
            "id": 840464287,
            "key": "id",
            "license": "https:\/\/developers.google.com\/freebase\/",
            "license_text": "Freebase constitutes a snapshot of the data stored in Freebase and the Schema that structures it, and are provided under the same CC-BY license. The Freebase\/Wikidata mappings are provided under the CC0 license.",
            "license_type": "CC BY",
            "name": "freebase",
            "prefix": "fb",
            "url": "https:\/\/developers.google.com\/freebase\/"
        },
        {
            "description": "Location data for Mobile Advertising, Developers, and Enterprise solutions.",
            "fullname": "Factual",
            "id": 404734193,
            "key": "id",
            "license": "http:\/\/factual.com\/tos",
            "license_text": "All of the information and data made available via the Sites ('Site Data') is provided solely to enable you to learn about Factual and the Services. You are not licensed to store, copy, or use any Site Data for any other purpose.",
            "license_type": "Restricted",
            "name": "factual",
            "prefix": "fct",
            "url": "https:\/\/github.com\/Factual\/places"
        },
        {
            "description": "Country codes for each member (and non-member) country, used by FIFA during competition.",
            "fullname": "Federation Internationale de Football Association",
            "id": 1158832829,
            "key": "id",
            "license": "http:\/\/www.rsssf.com\/miscellaneous\/fifa-codes.html",
            "license_text": "You are free to copy this document in whole or part provided that proper acknowledgement is given to the author. All rights reserved.",
            "license_type": "CC BY 1.0",
            "name": "fifa",
            "prefix": "fifa",
            "url": "http:\/\/www.rsssf.com\/miscellaneous\/fifa-codes.html"
        },
        {
            "description": "National Land Survey of Finland performs various kinds of cadastral surveys such as parcelling and reallocations of pieces of land, produces map data and promotes the joint use of such data.",
            "fullname": "NLS National Land Survey of Finland",
            "id": 857125801,
            "key": "id",
            "license": "http:\/\/www.maanmittauslaitos.fi\/en\/opendata-licence-cc40",
            "license_text": "Mention the name of the Licensor, the name of the dataset(s) and the time when the National Land Survey has delivered the dataset(s) (e.g.: contains data from the National Land Survey of Finland Topographic Database",
            "license_type": "CC BY 4.0",
            "name": "figov",
            "prefix": "figov",
            "url": "http:\/\/www.maanmittauslaitos.fi\/en\/digituotteet\/municipal-division-finland"
        },
        {
            "description": "The American National Standards Institute (ANSI) operates the National Standards System Network (NSSN). This powerful reference tool provides 24-hour access to over 65,000 references to standards and specifications from the U.S. government, U.S. private sector organizations and international standards organizations.",
            "fullname": "Federal Information Processing Standards",
            "id": 840464229,
            "key": "code",
            "license": "https:\/\/www.usa.gov\/government-works",
            "license_text": "United States government creative works, including writing, images, and computer code, are usually prepared by officers or employees of the United States government as part of their official duties. A government work is generally not subject to copyright in the United States and there is generally no copyright restriction on reproduction, derivative works, distribution, performance, or display of a government work.",
            "license_type": "CC0",
            "name": "fips",
            "prefix": "fips",
            "url": "http:\/\/www.nist.gov\/itl\/fips.cfm"
        },
        {
            "description": "Open platform for French public data.",
            "fullname": "Open Data France",
            "id": 1108725001,
            "key": "id",
            "license": "https:\/\/www.data.gouv.fr\/en\/terms\/",
            "license_text": "The Open License is part of an international context and is compatible with the standards of open data licenses developed abroad, in particular those of the Government of the United Kingdom (Open Government License) and other international standards (ODC-BY, CC-BY 2.0).",
            "license_type": "CC BY 2.0",
            "name": "frgov",
            "prefix": "frgov",
            "url": "https:\/\/www.data.gouv.fr\/en\/datasets\/fond-de-carte-des-codes-postaux\/"
        },
        {
            "description": "Country codes used be the Global Administrative Unit Layers from the Food and Agriculture Organization. The entity codes are integers, assigned sequentially, with no duplication between layers; that is, no country has the same code as any primary subdivision, and so on.",
            "fullname": "Global Administrative Unit Layers - Food and Agriculture Organization",
            "id": 1158832835,
            "key": "id",
            "license": "http:\/\/www.fao.org\/contact-us\/terms\/en\/",
            "license_text": "FAO encourages unrestricted use of news releases provided on the FAO website, and no formal permission is required to reproduce these materials.",
            "license_type": "CC0",
            "name": "gaul",
            "prefix": "gaul",
            "url": "http:\/\/www.fao.org\/countryprofiles\/iso3list\/en\/"
        },
        {
            "description": "Formerly FIPS PUB 10-4, these country codes were used by the National Geospatial-Intelligence Agency (NGA) to define 'Countries, Dependencies, Areas of Special Sovereignty, and Their Principal Administrative Divisions'. GEC maintenance was discontinued on 31 December 2014.",
            "fullname": "Geopolitical Entities and Codes",
            "id": 1158832823,
            "key": "",
            "license": "http:\/\/geonames.nga.mil\/gns\/html\/namefiles.html",
            "license_text": "Foreign geographic names data is freely available.",
            "license_type": "CC0",
            "name": "gec",
            "prefix": "gec",
            "url": "http:\/\/geonames.nga.mil\/gns\/html\/countrycodes.html"
        },
        {
            "description": "Property prefix.",
            "fullname": "geom",
            "id": 1108830733,
            "key": "id",
            "license": "CC0",
            "name": "geom",
            "prefix": "geom",
            "url": ""
        },
        {
            "description": "The GeoNames geographical database covers all countries and contains over eleven million placenames that are available for download free of charge.",
            "fullname": "GeoNames",
            "id": 404734175,
            "key": "id",
            "license": "http:\/\/www.geonames.org\/about.html",
            "license_text": "The GeoNames geographical database is available for download free of charge under a creative commons attribution license.",
            "license_type": "CC BY",
            "name": "geonames",
            "prefix": "gn",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/geonames_remarks.md",
            "url": "http:\/\/www.geonames.org\/"
        },
        {
            "description": "GeoPlanet provides an open, permanent, and intelligent infrastructure for geo-referencing data on the Internet. (Cached, accessed: 2017-05-11, via: https:\/\/web.archive.org\/web\/20111028163611\/http:\/\/developer.yahoo.com\/geo\/geoplanet\/data\/).",
            "fullname": "Yahoo! GeoPlanet",
            "id": 404734177,
            "key": "id",
            "license": "http:\/\/developer.yahoo.com\/geo\/geoplanet\/data\/",
            "license_text": "This page provides open access to the underlying data under a Creative Commons Attribution license so that you can incorporate WOEIDs and the GeoPlanet hierarchy into your own applications.",
            "license_type": "CC BY",
            "name": "geoplanet",
            "prefix": "gp",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/geoplanet_remarks.md",
            "url": "http:\/\/developer.yahoo.com\/geo\/geoplanet\/"
        },
        {
            "description": "Administrative subdivisions of countries; a comprehensive world reference, 1900 to 1998. Gwillim Law: 'As far as I'm concerned, HASC codes are in the public domain - to encourage people or organizations to use them for data communication.' The 'hasc:id' is a variable property mapping, depending on the placetype of a record.",
            "fullname": "Statoids HASC",
            "id": 1108827445,
            "key": "id",
            "license": "http:\/\/www.statoids.com\/ihasc.html",
            "license_text": "CC0 per email with Gwillim Law of Statoids on August 11, 2015.",
            "license_type": "CC0",
            "name": "hasc",
            "prefix": "hasc",
            "url": "http:\/\/www.statoids.com\/"
        },
        {
            "description": "HRI is a web service for fast and easy access to open data sources between the cities of Helsinki, Espoo, Vantaa and Kauniainen.",
            "fullname": "Helsinki City Real Estate Department",
            "id": 1108726815,
            "key": "",
            "license": "http:\/\/www.hri.fi\/dataset\/paakaupunkiseudun-aluejakokartat",
            "license_text": "You are free to: Share, copy and redistribute the material in any medium or format and Adapt, remix, transform, and build upon the material for any purpose, even commercially.",
            "license_type": "CC BY 4.0",
            "name": "hkigis",
            "prefix": "hkigis",
            "url": "http:\/\/www.hel2.fi\/tietokeskus\/data\/kartta_aineistot\/PKS_Kartta_Rajat_KML2011.zip"
        },
        {
            "description": "HRI is a web service for fast and easy access to open data sources between the cities of Helsinki, Espoo, Vantaa and Kauniainen.",
            "fullname": "Helsinki Region Infoshare",
            "id": 874342855,
            "key": "id",
            "license": "http:\/\/www.hri.fi\/en\/dataset\/helsingin-kaupunginosat",
            "license_text": "You are free to: Share, copy and redistribute the material in any medium or format and Adapt, remix, transform, and build upon the material for any purpose, even commercially.",
            "license_type": "CC BY 4.0",
            "name": "hsgov",
            "prefix": "hsgov",
            "url": "http:\/\/ptp.hel.fi\/avoindata\/aineistot\/Helsingin_kaupunginosat.zip"
        },
        {
            "description": "The International Air Transport Association (IATA) is the trade association for the world's airlines, representing some 265 airlines or 83% of total air traffic.",
            "fullname": "International Air Transport Association",
            "id": 840464241,
            "key": "code",
            "license": "http:\/\/www.iata.org\/Pages\/terms.aspx",
            "license_text": "All rights are reserved.",
            "license_type": "Restricted",
            "name": "iata",
            "prefix": "iata",
            "url": "http:\/\/www.iata.org\/"
        },
        {
            "description": "The International Civil Aviation Organization (ICAO) is a UN specialized agency, established by States in 1944 to manage the administration and governance of the Convention on International Civil Aviation (Chicago Convention).",
            "fullname": "International Civil Aviation Organization",
            "id": 840464249,
            "key": "code",
            "license": "http:\/\/www.icao.int\/Pages\/Disclaimer.aspx",
            "license_text": "ICAO grants permission to Users to visit the Site and to download, preprint and copy the information, documents and materials (collectively, 'Materials') from the Site for the User's personal, non-commercial use, without any right to resell or redistribute them or to compile or create derivative works therefrom, subject to the terms and conditions outlined below, and also subject to more specific restrictions that may apply to specific Material within this Site. ",
            "license_type": "Restricted",
            "name": "icao",
            "prefix": "icao",
            "url": "http:\/\/www.icao.int\/"
        },
        {
            "description": "The public body responsible for regulating and coordinating the National Statistical System and Geographic Information, as well as to capture and disseminate information of Mexico.",
            "fullname": "Instituto Nacional de Estad\u00edstica y Geograf\u00eda (INEGI)",
            "id": 1158808187,
            "key": "id",
            "license": "http:\/\/www.beta.inegi.org.mx\/inegi\/terminos.html",
            "license_text": "You can make and distribute copies of the information, without altering or deleting metadata. You can disseminate and publish the information.",
            "license_type": "CC BY (equivalent)",
            "name": "inegi",
            "prefix": "inegi",
            "url": "http:\/\/http:\/\/www.inegi.org.mx\/"
        },
        {
            "description": "These codes identify the nationality of athletes and teams during Olympic events.",
            "fullname": "International Olympics Committee",
            "id": 1158832825,
            "key": "id",
            "license": "https:\/\/www.olympic.org\/terms-of-service",
            "license_text": "All elements of the Site, including the IOC Content, are protected by copyright, trade dress, moral rights, trademark and other laws relating to the protection of intellectual property.",
            "license_type": "Restricted",
            "name": "ioc",
            "prefix": "ioc",
            "url": "https:\/\/www.olympic.org\/the-ioc"
        },
        {
            "description": "ISO is an independent, non-governmental international organization with a membership of 163 national standards bodies.",
            "fullname": "International Organization for Standardization",
            "id": 1108931861,
            "key": "id",
            "license": "https:\/\/www.iso.org\/privacy-and-copyright.html",
            "license_text": "All content on ISO Online is copyright protected. The copyright is owned by ISO. Any use of the content, including copying of it in whole or in part, for example to another Internet site, is prohibited and would require written permission from ISO.",
            "license_type": "Restricted",
            "name": "iso",
            "prefix": "iso",
            "url": "http:\/\/www.iso.org\/"
        },
        {
            "description": "ITU country codes are used to identify radio transmitter locations.",
            "fullname": "International Telecommunications Union",
            "id": 1158832821,
            "key": "id",
            "license": "https:\/\/www.itu.int\/en\/Pages\/copyright.aspx",
            "license_text": "ITU holds copyright in the information available on this Web site, unless otherwise stated. Copyright in any third-party materials found on this Web site must also be respected.",
            "license_type": "Restricted",
            "name": "itu",
            "prefix": "itu",
            "url": "https:\/\/www.itu.int\/online\/mm\/scripts\/gensel8"
        },
        {
            "description": "Official website for the City of Kuopio, Finland.",
            "fullname": "City of Kuopio",
            "id": 1108729077,
            "key": "",
            "license": "https:\/\/www.avoindata.fi\/data\/fi\/dataset\/kuopion-kaupunginosat",
            "license_text": "You are free to: Share, copy and redistribute the material in any medium or format and Adapt, remix, transform, and build upon the material for any purpose, even commercially.",
            "license_type": "CC BY 4.0",
            "name": "kuogov",
            "prefix": "kuogov",
            "url": "https:\/\/www.avoindata.fi\/data\/fi\/dataset\/kuopion-kaupunginosat\/resource\/6ca89290-3743-4832-9ed6-03d8cf9b2d5f"
        },
        {
            "description": "Official Certified Neighborhood Council boundaries in the City of Los Angeles created and maintained by the Bureau of Engineering \/ GIS Mapping Division.",
            "fullname": "City of Los Angeles Neighborhood Councils (Certified)",
            "id": 1024497679,
            "key": "",
            "license": "https:\/\/data.lacity.org\/A-Well-Run-City\/Neighborhood-Councils-Certified-\/fu65-dz2f\/about",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "lacity",
            "prefix": "lacity",
            "url": "https:\/\/data.lacity.org\/A-Well-Run-City\/Neighborhood-Councils-Certified-\/fu65-dz2f"
        },
        {
            "description": "",
            "fullname": "City of Los Angeles Office of Finance",
            "id": 1158784149,
            "key": "id",
            "license": "",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "lacity_oof",
            "prefix": "lacity_oof",
            "url": "https:\/\/data.lacity.org\/A-Prosperous-City\/Listing-of-Active-Businesses\/6rrh-rzua"
        },
        {
            "description": "The Los Angeles Times.",
            "fullname": "Los Angeles Times",
            "id": 1108962957,
            "key": "id",
            "license": "http:\/\/www.tronc.com\/central-terms-of-service\/",
            "license_text": "If you operate a Web site and wish to link to the Site, you may do so provided you agree to cease such link upon request from us. No other use is permitted without prior written permission of tronc.",
            "license_type": "Restricted",
            "name": "latimes",
            "prefix": "latimes",
            "url": "http:\/\/www.latimes.com\/"
        },
        {
            "description": "",
            "fullname": "label",
            "id": 1108955855,
            "key": "id",
            "license": "CC0",
            "name": "lbl",
            "prefix": "lbl",
            "url": ""
        },
        {
            "description": "Property prefix.",
            "fullname": "lieu",
            "id": 1141961795,
            "key": "guid",
            "license": "",
            "name": "lieu",
            "prefix": "lieu",
            "url": "https:\/\/github.com\/openvenues\/lieu"
        },
        {
            "description": "The Library of Congress is the largest library in the world, with millions of books, recordings, photographs, newspapers, maps and manuscripts in its collections. The Library is the main research arm of the U.S. Congress and the home of the U.S. Copyright Office.",
            "fullname": "Library of Congress",
            "id": 840464301,
            "key": "id",
            "license": "https:\/\/www.loc.gov\/legal\/",
            "license_text": "Unless otherwise indicated on this site, the Library of Congress has no objection to the international use and reuse of Library U.S. Government works on loc.gov. These works are also available for worldwide use and reuse under CC0 1.0 Universal.",
            "license_type": "CC0",
            "name": "loc",
            "prefix": "loc",
            "url": "http:\/\/www.loc.gov"
        },
        {
            "description": "LocalWiki is a grassroots effort to collect, share and open the world\u2019s local knowledge. Includes data on local governments, neighborhoods, streets, social movements, noteworthy local figures, social services, schools, etc.",
            "fullname": "LocalWiki",
            "id": 1158844639,
            "key": "",
            "license": "https:\/\/localwiki.org\/main\/Copyrights",
            "license_text": "All of the media and written content in LocalWiki is licensed under the Creative Commons Attribution 4.0 license (CC BY 4.0), unless noted otherwise.",
            "license_type": "CC BY 4.0",
            "name": "localwiki",
            "prefix": "localwiki",
            "url": "https:\/\/localwiki.org\/"
        },
        {
            "description": "The United Nations Statistics Division compiles and disseminates global statistical information, develops standards and norms for statistical activities, and supports efforts to strengthen national statistical systems.",
            "fullname": "UNSD (United Nations Statistics Division)",
            "id": 1158856069,
            "key": "code",
            "license": "http:\/\/www.un.org\/en\/sections\/about-website\/terms-use\/",
            "license_text": "The United Nations reserves the right to deny in its sole discretion any user access to this Site or any portion thereof without notice.",
            "license_type": "Restricted",
            "name": "unsd",
            "prefix": "m49",
            "url": "https:\/\/unstats.un.org\/unsd\/methodology\/m49\/"
        },
        {
            "description": "MARC is a standard for encoding bibliographic materials in electronic form. The Library of Congress maintains the MARC code list for countries.",
            "fullname": "Machine-Readable Cataloging - Library of Congress",
            "id": 1158832837,
            "key": "id",
            "license": "https:\/\/www.loc.gov\/legal\/",
            "license_text": "Unless otherwise indicated on this site, the Library of Congress has no objection to the international use and reuse of Library U.S. Government works on loc.gov. These works are also available for worldwide use and reuse under CC0 1.0 Universal.",
            "license_type": "CC0",
            "name": "marc",
            "prefix": "marc",
            "url": "http:\/\/www.loc.gov\/marc\/countries\/cou_home.html"
        },
        {
            "description": "Mesoshapes are a product of Mapzen for Who's On First.",
            "fullname": "Mesoshapes",
            "id": 1108756907,
            "key": "",
            "license": "https:\/\/github.com\/whosonfirst-data\/whosonfirst-data\/blob\/master\/LICENSE.md",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "meso",
            "prefix": "meso",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/meso_remarks.md",
            "url": "https:\/\/github.com\/whosonfirst-data\/whosonfirst-data\/blob\/master\/LICENSE.md"
        },
        {
            "description": "Mapshaper is software for editing Shapefile, GeoJSON, TopoJSON and several other data formats, written in JavaScript.",
            "fullname": "Mapshaper",
            "id": 404734195,
            "key": "",
            "license": "http:\/\/mozilla.org\/MPL\/2.0\/",
            "license_text": "This Source Code Form is subject to the terms of the Mozilla Public License, v. 2.0. If a copy of the MPL was not distributed with this file, You can obtain one at http:\/\/mozilla.org\/MPL\/2.0\/.",
            "license_type": "MPL, v2.0",
            "name": "mapshaper",
            "prefix": "ms",
            "url": "https:\/\/github.com\/mbloch\/mapshaper"
        },
        {
            "description": "A Tenderloin of many neighbourhoods.",
            "fullname": "Mini Tenders",
            "id": 404734209,
            "key": "id",
            "license": "http:\/\/www.thebolditalic.com\/articles\/1101-mini-tenders",
            "license_text": "Data is assumed to be in the Public Domain.",
            "license_type": "Public domain (assumed)",
            "name": "minitenders",
            "prefix": "mt",
            "url": "http:\/\/www.thebolditalic.com\/articles\/1101-mini-tenders"
        },
        {
            "description": " Mapzen is an open, sustainable, and accessible mapping platform. Our tools let you display, search, and navigate your world.",
            "fullname": "Mapzen",
            "id": 404734197,
            "key": "",
            "license": "https:\/\/mapzen.com\/terms\/",
            "license_text": "Subject to these Terms, Mapzen hereby grants to you a non-exclusive, non-transferable, non-sublicensable license during the Term to: (i) copy and use the Tools solely to develop products and services to be made available by you ('Your Products'), and to distribute elements of the Tools as incorporated into Your Products; (ii) use and access the Services as provided by Mapzen subject to the Rate Limits; and (iii) if you've ordered Mapzen Data Products, use the Mapzen Data Products for your internal use and only as part of Your Products which are provided directly to end users, and not for resale or for redistribution or use in conjunction with, or as part of, the products or services of others. Except for the foregoing license, Mapzen and its suppliers own all right, title and interest in and to the Services, Tools and Mapzen Data Products, and no other licenses are granted to you, whether express or implied.",
            "license_type": "CC0",
            "name": "mapzen",
            "prefix": "mz",
            "url": "https:\/\/www.mapzen.com\/"
        },
        {
            "description": "Country, region and city boundary data from OpenStreetMap, served monthly until October 2016.",
            "fullname": "Mapzen Borders",
            "id": 840464303,
            "key": "id",
            "license": "https:\/\/mapzen.com\/terms\/",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "mapzenborders",
            "prefix": "mzb",
            "url": "https:\/\/mapzen.com\/data\/borders\/"
        },
        {
            "description": "Property prefix.",
            "fullname": "name",
            "id": 1108828507,
            "key": "id",
            "license": "N\/A",
            "license_text": "",
            "license_type": "CC0",
            "name": "name",
            "prefix": "name",
            "url": ""
        },
        {
            "description": "Natural Earth is a public domain map dataset available at 1:10m, 1:50m, and 1:110 million scales, which features tightly integrated vector and raster data.",
            "fullname": "Natural Earth",
            "id": 404734179,
            "key": "",
            "license": "http:\/\/www.naturalearthdata.com\/about\/terms-of-use\/",
            "license_text": "No permission is needed to use Natural Earth. Crediting the authors is unnecessary.",
            "license_type": "Public Domain (assumed)",
            "name": "naturalearth",
            "prefix": "ne",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/naturalearth_remarks.md",
            "url": "http:\/\/www.naturalearthdata.com\/"
        },
        {
            "description": "Home of Null Island.",
            "fullname": "Null Island",
            "id": 404734211,
            "key": "",
            "license": "N\/A",
            "license_text": "",
            "license_type": "",
            "name": "nullisland",
            "prefix": "ni",
            "url": "http:\/\/www.nullisland.com\/"
        },
        {
            "description": "Open Data portal for the City of New Orleans, LA.",
            "fullname": "City of New Orleans, Office of Information Technology and Innovation, Enterprise Information Team",
            "id": 1108732585,
            "key": "",
            "license": "https:\/\/data.nola.gov\/Geographic-Base-Layers\/Neighborhoods\/92zg-wzkq",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "nolagis",
            "prefix": "nolagis",
            "url": "https:\/\/data.nola.gov\/Geographic-Base-Layers\/Neighborhoods\/92zg-wzkq"
        },
        {
            "description": "Open Data portal for New York City, NY.",
            "fullname": "NYC OpenData",
            "id": 656342179,
            "key": "id",
            "license": "http:\/\/legistar.council.nyc.gov\/ViewReport.ashx?M=R&N=Text&GID=61&ID=1090992&GUID=B1263195-66B9-48AD-A381-57584D623443&Title=Legislation+Text",
            "license_text": "Such public data sets shall be made available without any registration requirement, license requirement or restrictions on their use provided that the department may require a third party providing to the public any public data set, or application utilizing such data set, to explicitly identify the source and version of the public data set, and a description of any modifications made to such public data set.",
            "license_type": "CC0 (assumed)",
            "name": "nycgov",
            "prefix": "nycgov",
            "url": "https:\/\/data.cityofnewyork.us\/"
        },
        {
            "description": "Open Data portal for New York City, NY.",
            "fullname": "New York City Department of Consumer Affairs",
            "id": 1158783299,
            "key": "license",
            "license": "http:\/\/legistar.council.nyc.gov\/ViewReport.ashx?M=R&N=Text&GID=61&ID=1090992&GUID=B1263195-66B9-48AD-A381-57584D623443&Title=Legislation+Text",
            "license_text": "Such public data sets shall be made available without any registration requirement, license requirement or restrictions on their use provided that the department may require a third party providing to the public any public data set, or application utilizing such data set, to explicitly identify the source and version of the public data set, and a description of any modifications made to such public data set.",
            "license_type": "CC0 (assumed)",
            "name": "nycgov_dca",
            "prefix": "nycgov_dca",
            "url": "https:\/\/data.cityofnewyork.us\/Business\/Legally-Operating-Businesses\/w7w3-xahh\/data"
        },
        {
            "description": "Open Data portal for New York City, NY.",
            "fullname": "New York City Department of Health and Mental Hygiene",
            "id": 1158783297,
            "key": "camis",
            "license": "http:\/\/legistar.council.nyc.gov\/ViewReport.ashx?M=R&N=Text&GID=61&ID=1090992&GUID=B1263195-66B9-48AD-A381-57584D623443&Title=Legislation+Text",
            "license_text": "Such public data sets shall be made available without any registration requirement, license requirement or restrictions on their use provided that the department may require a third party providing to the public any public data set, or application utilizing such data set, to explicitly identify the source and version of the public data set, and a description of any modifications made to such public data set.",
            "license_type": "CC0 (assumed)",
            "name": "nycgov_dohmh",
            "prefix": "nycgov_dohmh",
            "url": "https:\/\/data.cityofnewyork.us\/Health\/DOHMH-New-York-City-Restaurant-Inspection-Results\/xx67-kt59"
        },
        {
            "description": "Open Data portal for New York City, NY.",
            "fullname": "NYC OpenData - Subway Stations",
            "id": 1108960969,
            "key": "objectid",
            "license": "http:\/\/legistar.council.nyc.gov\/ViewReport.ashx?M=R&N=Text&GID=61&ID=1090992&GUID=B1263195-66B9-48AD-A381-57584D623443&Title=Legislation+Text",
            "license_text": "Such public data sets shall be made available without any registration requirement, license requirement or restrictions on their use provided that the department may require a third party providing to the public any public data set, or application utilizing such data set, to explicitly identify the source and version of the public data set, and a description of any modifications made to such public data set.",
            "license_type": "CC0 (assumed)",
            "name": "nycgov_subway",
            "prefix": "nycgov_subway",
            "url": "https:\/\/data.cityofnewyork.us\/Transportation\/Subway-Stations\/arq3-7z49"
        },
        {
            "description": "The New York Times.",
            "fullname": "The New York Times",
            "id": 840464273,
            "key": "id",
            "license": "https:\/\/www.nytimes.com\/content\/help\/rights\/terms\/terms-of-service.html",
            "license_text": "You may not sublicense, assign or transfer any licenses granted by NYTimes.com, and any attempt at such sublicense, assignment or transfer shall be null and void.",
            "license_type": "Restricted",
            "name": "nytimes",
            "prefix": "nyt",
            "url": "http:\/\/www.nytimes.com\/"
        },
        {
            "description": "OurAirports is a free site where visitors can explore the world's airports. [...] This is an open-data web site, after all, and we don't believe that 'open' means 'we can benefit from it, but we'll hide it from everyone else.",
            "fullname": "OurAirports",
            "id": 404734181,
            "key": "id",
            "license": "http:\/\/ourairports.com\/",
            "license_text": "OurAirports is a public site, and by 'public', we mean PUBLIC.",
            "license_type": "Public domain",
            "name": "ourairports",
            "prefix": "oa",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/ourairports_remarks.md",
            "url": "http:\/\/ourairports.com\/data\/"
        },
        {
            "description": "Open Data portal for the City of Oakland, CA.",
            "fullname": "Oakland Community and Economic Development Department",
            "id": 1108794097,
            "key": "",
            "license": "https:\/\/data.oaklandnet.com\/Property\/Oakland-Neighborhoods\/7zky-kcq9\/about",
            "license_text": "",
            "license_type": "Public Domain",
            "name": "oakced",
            "prefix": "oakced",
            "url": "https:\/\/data.oaklandnet.com\/Property\/Oakland-Neighborhoods\/7zky-kcq9"
        },
        {
            "description": "A non-ministerial government agency that acts as the national mapping agency for Great Britain.",
            "fullname": "Ordnance Survey",
            "id": 874390485,
            "key": "",
            "license": "https:\/\/www.ordnancesurvey.co.uk\/business-and-government\/licensing\/using-creating-data-with-os-products\/os-opendata.html",
            "license_text": "You are free to: copy, publish, distribute and transmit the Information; adapt the Information; exploit the Information commercially and non-commercially for example, by combining it with other Information, or by including it in your own product or application. You must (where you do any of the above): acknowledge the source of the Information in your product or application by including or linking to any attribution statement specified by the Information Provider(s) and, where possible, provide a link to this licence.",
            "license_type": "OGL, v3.0",
            "name": "ordnancesurvey",
            "prefix": "os",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/os_remarks.md",
            "url": "https:\/\/www.ordnancesurvey.co.uk"
        },
        {
            "description": "Property prefix (for concordances).",
            "fullname": "OpenStreetMap",
            "id": 1158861161,
            "key": "id",
            "license": "ODbL",
            "name": "osm",
            "prefix": "osm",
            "url": "https:\/\/openstreetmap.org"
        },
        {
            "description": "Official website for the City of Oulu, Finland.",
            "fullname": "City of Oulu",
            "id": 1108728833,
            "key": "",
            "license": "http:\/\/www.ouka.fi\/oulu\/oulu-tietoa\/kayttoehdot",
            "license_text": "The license allows you to share, copy and distribute the material remains in any medium and in the form of, and Modify, combine and edit the material and create the basis for new materials.",
            "license_type": "CC BY 4.0",
            "name": "oulugov",
            "prefix": "oulugov",
            "url": "http:\/\/www.ouka.fi\/oulu\/oulu-tietoa\/avoin-data-aineisto"
        },
        {
            "description": "OUTgoing: The Hidden History of New York's Gay Nightlife by Jeff Ferzoco.",
            "fullname": "OUTgoing",
            "id": 1108952683,
            "key": "",
            "license": "N\/A",
            "license_text": "Data is assumed to be in the Public Domain.",
            "license_type": "Public Domain (assumed)",
            "name": "outgoing",
            "prefix": "out",
            "url": "http:\/\/outgoingnyc.com\/"
        },
        {
            "description": "An open dataset of administrative areas in New York City.",
            "fullname": "Pediacities",
            "id": 907131617,
            "key": "",
            "license": "http:\/\/catalog.opendata.city\/dataset\/pediacities-nyc-neighborhoods\/resource\/91778048-3c58-449c-a3f9-365ed203e914",
            "license_text": "Subject to the terms and conditions of this License, the Licensor grants to You a worldwide, royalty-free, non-exclusive, terminable (but only under Section 9) license to Use the Database for the duration of any applicable copyright and Database Rights.",
            "license_type": "ODC-By, v1.0",
            "name": "pedia",
            "prefix": "pedia",
            "url": "http:\/\/catalog.opendata.city\/dataset\/pediacities-nyc-neighborhoods"
        },
        {
            "description": "Confirmed Public Domain by Kevin Martin of the Portland BPS on 2016-10-07 <Kevin.Martin@portlandoregon.gov>",
            "fullname": "City of Portland Bureau of Planning and Sustainability",
            "id": 1108713463,
            "key": "",
            "license": "https:\/\/www.arcgis.com\/home\/item.html?id=c11815647b3949faa20b16cf50ab214d",
            "license_text": "'Intention is free and open use, licensed for the public domain. For now, you can assume the data is completely open.'",
            "license_type": "Public Domain",
            "name": "porbps",
            "prefix": "porbps",
            "url": "http:\/\/gis.pdx.opendata.arcgis.com\/datasets\/c11815647b3949faa20b16cf50ab214d_125"
        },
        {
            "description": "A gazetteer of non-overlapping, authoritative polygons around a curated list of places. Quattroshapes includes open data from government and other sources, many of which require attribution. See [remarks](https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/quattroshapes_remarks.md) for detail.",
            "fullname": "Quattroshapes",
            "id": 404734183,
            "key": "id",
            "license": "https:\/\/github.com\/foursquare\/quattroshapes\/blob\/master\/LICENSE.md",
            "license_text": "Please include attribution in your app, site, or printed work.",
            "license_type": "CC BY 2.0",
            "name": "quattroshapes",
            "prefix": "qs",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/quattroshapes_remarks.md",
            "url": "http:\/\/www.quattroshapes.com\/"
        },
        {
            "description": "The Quattroshapes point gazetteer. A big list of point locations that supplements the polygons gazetteer.",
            "fullname": "Quattroshapes Point Gazetteer",
            "id": 1108970625,
            "key": "id",
            "license": "https:\/\/github.com\/foursquare\/quattroshapes\/blob\/master\/LICENSE.md",
            "license_text": "Please include attribution in your app, site, or printed work.",
            "license_type": "CC BY 2.0",
            "name": "quattroshapes_pg",
            "prefix": "qs_pg",
            "url": "http:\/\/www.quattroshapes.com\/"
        },
        {
            "description": "Open Data portal for the City of Santa Barbara, CA.",
            "fullname": "The City of Santa Barbara",
            "id": 1158846735,
            "key": "",
            "license": "https:\/\/www.santabarbaraca.gov\/howdoi\/get\/webhelp\/policy.asp",
            "license_text": "",
            "license_type": "Public Domain",
            "name": "santabar",
            "prefix": "santabar",
            "url": "https:\/\/maps.santabarbaraca.gov\/Html5Viewer\/Index.html?configBase=\/Geocortex\/Essentials\/REST\/sites\/City_of_Santa_Barbara__Public\/viewers\/SantaBarbaraPublic\/virtualdirectory\/Resources\/Config\/Default"
        },
        {
            "description": "The San Diego Geographic Information Source (SanGIS) is a Joint Powers Authority (JPA) of the City of San Diego and the County of San Diego responsible for maintaining a regional geographic information system (GIS) landbase and data warehouse.",
            "fullname": "SanGIS\/SANDAG GIS Data Warehouse",
            "id": 1108800651,
            "key": "",
            "license": "http:\/\/www.sangis.org\/Legal_Notice.htm",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "sdgis",
            "prefix": "sdgis",
            "url": "http:\/\/rdw.sandag.org\/Account\/GetFSFile.aspx?dir=Law&Name=SDPD_BEATS.zip"
        },
        {
            "description": "Official data portal for the City of Seattle, WA.",
            "fullname": "Seattle City GIS Program",
            "id": 874455653,
            "key": "",
            "license": "https:\/\/data.seattle.gov\/data-policy",
            "license_text": "The Open Data Program makes the data generated by the City of Seattle openly available to the public.",
            "license_type": "Public Domain",
            "name": "seagv",
            "prefix": "seagv",
            "url": "https:\/\/data.seattle.gov\/dataset\/data-seattle-gov-GIS-shapefile-datasets\/f7tb-rnup"
        },
        {
            "description": "Official website for the San Francisco Arts Commission.",
            "fullname": "San Francisco Arts Commission",
            "id": 772974303,
            "key": "accession_id",
            "license": "http:\/\/www.sfartscommission.org\/terms-use",
            "license_text": "As a convenience to potential users, the City and County of San Francisco ('City') makes a variety of datasets ('Data') available for download through this website. Your use of the Data is subject to these terms of use, which constitute a legal agreement between You and the City and County of San Francisco ('City'). This legal agreement is referred to as the 'Terms of Use.'",
            "license_type": "CC BY (assumed)",
            "name": "sfac",
            "prefix": "sfac",
            "url": "http:\/\/www.sfartscommission.org\/"
        },
        {
            "description": "Open Data portal for the City of San Francisco, CA.",
            "fullname": "City of San Francisco",
            "id": 772974267,
            "key": "",
            "license": "https:\/\/data.sfgov.org\/terms-of-use",
            "license_text": "The Open Data Commons, Public Domain Dedication & Licence is a document intended to allow you to freely share, modify, and use this work for any purpose and without any restrictions. This licence is intended for use on databases or their contents ('data'), either together or individually.",
            "license_type": "PDDL 1.0",
            "name": "sfgov",
            "prefix": "sfgov",
            "url": "https:\/\/data.sfgov.org\/"
        },
        {
            "description": "Open Data portal for the City of San Francisco, CA.",
            "fullname": "City of San Francisco Treasurer & Tax Collector's Office (Registered Business Locations)",
            "id": 1158783301,
            "key": "id",
            "license": "https:\/\/data.sfgov.org\/terms-of-use",
            "license_text": "The Open Data Commons, Public Domain Dedication & Licence is a document intended to allow you to freely share, modify, and use this work for any purpose and without any restrictions. This licence is intended for use on databases or their contents ('data'), either together or individually.",
            "license_type": "PDDL 1.0",
            "name": "sfgov_rbl",
            "prefix": "sfgov_rbl",
            "url": "https:\/\/data.sfgov.org\/"
        },
        {
            "description": "SimpleGeo was a location aware services company that operated between 2009 and 2011. It is no longer an active company.",
            "fullname": "SimpleGeo",
            "id": 404734199,
            "key": "id",
            "license": "https:\/\/creativecommons.org\/publicdomain\/zero\/1.0\/",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "simplegeo",
            "prefix": "sg",
            "url": "https:\/\/www.simplegeo.com"
        },
        {
            "description": "The City of San Jose, CA's Planning Department website.",
            "fullname": "San Jose Planning Department",
            "id": 1108784751,
            "key": "",
            "license": "http:\/\/www.sanjoseca.gov\/DocumentCenter\/View\/55954",
            "license_text": "Data made open and freely available to the public to be republished, manipulated, or used in any other way without restriction.",
            "license_type": "CC0",
            "name": "sjp",
            "prefix": "sjp",
            "url": "https:\/\/www.sanjoseca.gov\/DocumentCenter\/View\/11287"
        },
        {
            "description": "Open San Mateo County contains data published by the County of San Mateo.",
            "fullname": "Open San Mateo County",
            "id": 874397695,
            "key": "",
            "license": "https:\/\/creativecommons.org\/publicdomain\/zero\/1.0\/legalcode",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "smcgov",
            "prefix": "smcgov",
            "url": "https:\/\/data.smcgov.org\/"
        },
        {
            "description": "Bezirke (districts) and Ortsteile (localities) provided under an open data license.",
            "fullname": "Senatsverwaltung fur Stadtentwicklung und Umwelt Berlin",
            "id": 1108808939,
            "key": "",
            "license": "http:\/\/www.stadtentwicklung.berlin.de\/geoinformation\/download\/nutzIII.pdf",
            "license_text": "Geodata and geodata services, including associated metadata, shall be used for: All currently known as well as for all future known commercial and not. Commercial use, as far as possible by special. Legal provisions, or contractual or legal rights. Third does not oppose it.",
            "license_type": "CC0 (assumed)",
            "name": "ssuberlin",
            "prefix": "ssuberlin",
            "url": "http:\/\/daten.berlin.de\/datensaetze?field_category_tid%5B%5D=231"
        },
        {
            "description": "Statistics Canada produces statistics that help Canadians better understand their country,its population, resources, economy, society and culture.",
            "fullname": "Statistics Canada",
            "id": 554906275,
            "key": "",
            "license": "http:\/\/www.statcan.gc.ca\/eng\/reference\/licence-eng",
            "license_text": "Subject to this agreement, Statistics Canada grants you a worldwide, royalty-free, non-exclusive licence to: use, reproduce, publish, freely distribute, or sell the Information; use, reproduce, publish, freely distribute, or sell Value-added Products; and, sublicence any or all such rights, under terms consistent with this agreement.",
            "license_type": "CC BY (assumed)",
            "name": "statcan",
            "prefix": "statcan",
            "url": "http:\/\/statcan.gc.ca\/"
        },
        {
            "description": "Statoids is an online database that organizes the primary and secondary administrative divisions for all countries, dependencies, and disputed areas of the world. Properties imported under CC-BY license from Statoids via special arrangement with the author.",
            "fullname": "Statoids",
            "id": 1158818289,
            "key": "",
            "license": "Data provided under special license agreement with http:\/\/www.statoids.com",
            "license_text": "The Licensed Materials are licensed, not sold to Mapzen. Statoids grants to Mapzen world-wide, fully-paid, perpetual, non-exclusive right to use the Licensed Materials for any purpose. The parties acknowledge and agree that such rights include, but are not limited to the right to (a) copy, duplicate, reproduce or publish the Licensed Materials or any of their contents; (b) distribute, assign transfer, sub-license the Licensed Materials, the contents of the Licensed Materials or copies thereof, to third parties by any means whatsoever; (d) change, modify, adapt, translate, reverse engineer, disassemble or decompile the Licensed Materials or create derivative works based on the Licensed Materials, or copies thereof, or (e) bundle, repackage, or include the Licensed Materials with any software in any way. By way of explanation, and not limitation, the parties acknowledge that the intent of this license is to give Mapzen all rights in the data other than title. Mapzen agrees that it shall use commercially reasonable efforts to attribute Statoids' ownership of the Licensed Material whenever it publishes the Licensed Materials.",
            "license_type": "CC BY",
            "name": "statoids",
            "prefix": "statoids",
            "url": "http:\/\/www.statoids.com"
        },
        {
            "description": "The Open Information portal for the Saint Paul, MN government.",
            "fullname": "Open Information Saint Paul",
            "id": 1108800107,
            "key": "",
            "license": "https:\/\/information.stpaul.gov\/City-Administration\/Establishing-an-Open-Information-Program-Resolutio\/v7qy-vtzb",
            "license_text": "The City shall develop and implement practices allowing it to prioritize the proactive release of high quality, machine-readable, disclosable city data, making it freely available via an open license without restrictions on use, reuse, or redistribution, ensuring it is fully accessible to the broadest range of users possible.",
            "license_type": "CC0 (assumed)",
            "name": "stpaulgov",
            "prefix": "stpaulgov",
            "url": "https:\/\/information.stpaul.gov\/City-Administration\/District-Council-Shapefile-Map\/dq4n-yj8b"
        },
        {
            "description": "The Surveying and Mapping Authority of the Republic of Slovenia's Open Data portal.",
            "fullname": "Surveying and Mapping Authority of the Republic of Slovenia",
            "id": 1108955989,
            "key": "",
            "license": "https:\/\/creativecommons.org\/licenses\/by\/2.5\/si\/legalcode",
            "license_text": "Licensor in accordance with the terms and conditions of this License grants the user free, nonexclusive, territorial and unlimited (for the duration of the rights stipulated by the Law on copyright) license to exercise the rights at work.",
            "license_type": "CC BY 2.5 SI",
            "name": "svn-sma",
            "prefix": "svn-sma",
            "url": "http:\/\/egp.gu.gov.si\/egp\/"
        },
        {
            "description": "The TGN is an evolving vocabulary, growing and changing thanks to contributions from Getty projects and other institutions.",
            "fullname": "Getty Thesaurus of Geographic Names",
            "id": 840464261,
            "key": "id",
            "license": "http:\/\/opendatacommons.org\/licenses\/by\/1-0\/",
            "license_text": "The Open Data Commons Attribution License is a license agreement intended to allow users to freely share, modify, and use this Database subject only to the attribution requirements set out in Section 4.",
            "license_type": "ODC-By, v1.0",
            "name": "tgn",
            "prefix": "tgn",
            "url": "https:\/\/www.getty.edu\/research\/tools\/vocabularies\/tgn\/index.html"
        },
        {
            "description": "The list is an online concert guide for Northern California and the west coast.",
            "fullname": "The List - Bay Area Concert Guide",
            "id": 1108973687,
            "key": "",
            "license": "http:\/\/www.calweb.net\/~skoepke\/",
            "license_text": "Public domain per email conversation on May 30th, 2017.",
            "license_type": "Public Domain",
            "name": "thelist",
            "prefix": "thelist",
            "url": "http:\/\/www.calweb.net\/~skoepke\/"
        },
        {
            "description": "Open Data portal for the City of Turku, Finland.",
            "fullname": "Turku City Government",
            "id": 1108728529,
            "key": "",
            "license": "http:\/\/www.lounaistieto.fi\/blog\/2015\/08\/18\/turun-palvelualuejakotilastoalueet\/",
            "license_text": "You are free to: Share - copy and redistribute the material in any medium or format and Adapt - remix, transform, and build upon the material for any purpose, even commercially.",
            "license_type": "CC BY 4.0",
            "name": "tkugov",
            "prefix": "tkugov",
            "url": "http:\/\/opendata.lounaistieto.fi\/aineistoja\/Turku_pienalueet.zip"
        },
        {
            "description": "Open Data portal for the City of Tampere, Finland.",
            "fullname": "Tampere City Survey GIS",
            "id": 1108728281,
            "key": "",
            "license": "http:\/\/www.tampere.fi\/tampereen-kaupunki\/tietoa-tampereesta\/avoin-data\/avoin-data-lisenssi.html",
            "license_text": "This is a worldwide, royalty-free, irrevocable, parallel license allowing the above-mentioned material to be freely available to 1. Copy and distribute. 2. Modify and utilize commercially and non-commercially to combine with other products. 3. Used as part of an application or service.",
            "license_type": "CC0 (assumed)",
            "name": "tmpgov",
            "prefix": "tmpgov",
            "url": "http:\/\/opendata.navici.com\/tampere\/opendata\/ows?service=WFS&version=2.0.0&request=GetFeature&typeName=opendata:KH_TILASTO&outputFormat=json"
        },
        {
            "description": "Open Data portal for Toronto, ON.",
            "fullname": "Toronto Social Development, Finance & Administration Department",
            "id": 1108833305,
            "key": "",
            "license": "http:\/\/www1.toronto.ca\/wps\/portal\/contentonly?vgnextoid=4a37e03bb8d1e310VgnVCM10000071d60f89RCRD",
            "license_text": "You are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "Open Government Licence - Ontario, v1.0",
            "name": "torsdfa",
            "prefix": "torsdfa",
            "url": "http:\/\/www1.toronto.ca\/wps\/portal\/contentonly?vgnextoid=04b489fe9c18b210VgnVCM1000003dd60f89RCRD&vgnextchannel=75d6e03bb8d1e310VgnVCM10000071d60f89RCRD"
        },
        {
            "description": "Transitland brings together many sources of transit data to build a directory of operators and feeds that can be edited by transit enthusiasts and developers.",
            "fullname": "Transitland",
            "id": 1108955939,
            "key": "onestop_id",
            "license": "https:\/\/transit.land\/an-open-project\/contributor-agreement.html",
            "license_text": "Mapzen hereby grants to You and You hereby accept a limited, non-exclusive, royalty free, non-transferable, non-sublicensable, freely revocable, worldwide license solely to use the Licensed Material to develop Products.",
            "license_type": "CC0",
            "name": "transitland",
            "prefix": "transitland",
            "url": "https:\/\/transit.land\/"
        },
        {
            "description": "The internation organization that manages the distinguishing signs of the place of registration of vehicles.",
            "fullname": "United Nations Convention for Road Traffic",
            "id": 1158860607,
            "key": "id",
            "license": "http:\/\/www.un.org\/en\/sections\/about-website\/copyright\/index.html",
            "license_text": "All rights reserved. None of the materials provided on this web site may be used, reproduced or transmitted, in whole or in part, in any form or by any means, electronic or mechanical, including photocopying, recording or the use of any information storage and retrieval system, except as provided for in the Terms and Conditions of Use of United Nations Web Sites, without permission in writing from the publisher.",
            "license_type": "Restricted",
            "name": "United Nations Convention for Road Traffic",
            "prefix": "uncrt",
            "url": "https:\/\/treaties.un.org\/doc\/Publication\/MTDSG\/Volume%20I\/Chapter%20XI\/xi-b-1.en.pdf"
        },
        {
            "description": "Used when a property value is not known. A placeholder for 'we do not know'.",
            "fullname": "unknown",
            "id": 1108830757,
            "key": "id",
            "license": "N\/A",
            "license_text": "N\/A",
            "license_type": "N\/A",
            "name": "unknown",
            "prefix": "unknown",
            "url": ""
        },
        {
            "description": "UN\/LOCODE is based on a code structure set up by ECLAC and a list of locations originating in ESCAP, developed in UNCTAD in co-operation with transport organisations like IATA and the ICS and with active contributions from national governments and commercial bodies. Note: Who's On First concatenates the UN\/LOCODE two-character country code and three-character feature code with a deliminator and names the result the 'id'.",
            "fullname": "UN\/LOCODE (United Nations Code for Trade and Transport Locations)",
            "id": 420573473,
            "key": "id",
            "license": "http:\/\/www.unece.org\/cefact\/locode\/locode_since1981.html",
            "license_text": "UN\/LOCODE is freely available to all interested users.",
            "license_type": "CC0",
            "name": "unlocode",
            "prefix": "unlc",
            "url": "http:\/\/www.unece.org\/cefact\/locode\/welcome.html"
        },
        {
            "alt": [
                {
                    "function": "display",
                    "extras": [
                        "scope",
                        "detail"
                    ]
                }
            ],
            "data_sources": [
                {
                    "default": "https:\/\/www.census.gov\/cgi-bin\/geo\/shapefiles\/index.php",
                    "alt-uscensus-display-terrestrial-zoom-10": "http:\/\/www2.census.gov\/geo\/tiger\/GENZ2015\/shp\/cb_2015_us_state_500k.zip"
                }
            ],
            "description": "The leading source of quality data about the nation's people and economy from the United States Census Bureau.",
            "fullname": "United States Census Bureau",
            "id": 1108739789,
            "key": "",
            "license": "https:\/\/www.census.gov\/data\/developers\/about\/terms-of-service.html",
            "license_text": "All U.S. Census Bureau materials, regardless of the media, are entirely in the public domain. There are no user fees, site licenses, or any special agreements etc for the public or private use, and or reuse of any census title. As tax funded product, it's all in the public record.",
            "license_type": "CC0",
            "name": "uscensus",
            "prefix": "uscensus",
            "url": "https:\/\/www.census.gov\/"
        },
        {
            "description": "ZIP Code Tabulation Areas (ZCTAs) are generalized areal representations of United States Postal Service (USPS) ZIP Code service areas.",
            "fullname": "US ZIP Code Tabulation Area",
            "id": 554867137,
            "key": "id",
            "license": "https:\/\/www.census.gov\/data\/developers\/about\/terms-of-service.html",
            "license_text": "All U.S. Census Bureau materials, regardless of the media, are entirely in the public domain. There are no user fees, site licenses, or any special agreements etc for the public or private use, and or reuse of any census title. As tax funded product, it's all in the public record.",
            "license_type": "CC0",
            "name": "uszcta",
            "prefix": "uszcta",
            "url": "http:\/\/www.census.gov\/geo\/reference\/zctas.html"
        },
        {
            "description": "Open Data portal for the City of Vancouver.",
            "fullname": "Vancouver Planning and Development Services",
            "id": 1108906615,
            "key": "",
            "license": "http:\/\/vancouver.ca\/your-government\/open-data-catalogue.aspx#tab19099",
            "license_text": "you are free to copy, modify, publish, translate, adapt, distribute or otherwise use the Information in any medium, mode or format for any lawful purpose.",
            "license_type": "Open Government Licence - British Columbia, v2.0",
            "name": "vanpds",
            "prefix": "vanpds",
            "url": "http:\/\/data.vancouver.ca\/datacatalogue\/localAreaBoundary.htm"
        },
        {
            "description": "A map of neighborhood boundaries in the District of Columbia.",
            "fullname": "Washington Post",
            "id": 1108724061,
            "key": "",
            "license": "http:\/\/opendatadc.org\/dataset\/neighborhood-boundaries-217-neighborhoods-washpost-justgrimes",
            "license_text": "The Creative Commons Attribution license allows re-distribution and re-use of a licensed work on the condition that the creator is appropriately credited.",
            "license_type": "CC-BY",
            "name": "wapo",
            "prefix": "wapo",
            "url": "http:\/\/opendatadc.org\/dataset\/neighborhood-boundaries-217-neighborhoods-washpost-justgrimes"
        },
        {
            "description": "Concordances against Wikidata; public domain structured data.",
            "fullname": "Wikidata",
            "id": 420577535,
            "key": "id",
            "license": "https:\/\/creativecommons.org\/publicdomain\/zero\/1.0\/",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "wikidata",
            "prefix": "wd",
            "url": "https:\/\/www.wikidata.org\/"
        },
        {
            "fullname": "Wikipedia",
            "id": 404734189,
            "key": "page",
            "license": "https:\/\/en.wikipedia.org\/wiki\/Wikipedia:Copyrights",
            "license_text": "Most of Wikipedia's text and many of its images are co-licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported License (CC BY-SA) and the GNU Free Documentation License (GFDL) (unversioned, with no invariant sections, front-cover texts, or back-cover texts).",
            "license_type": "CC BY-SA 3.0",
            "name": "wikipedia",
            "prefix": "wk",
            "url": "http:\/\/www.wikipedia.org\/"
        },
        {
            "description": "Country abbreviations used in weather reports from the World Meteorological Organization.",
            "fullname": "World Meteorological Organization",
            "id": 1158832833,
            "key": "id",
            "license": "https:\/\/public.wmo.int\/en\/copyright",
            "license_text": "Reproduction of short excerpts of WMO materials, figures and photographs on this website is authorized free of charge and without formal written permission provided that the original source is acknowledged. Reproduction of videos files are authorized free of charge and without formal written permission provided that the original source is acknowledged and subject to the standard creative commons licensing conditions Creative Commons License.",
            "license_type": "CC BY-NC-ND 4.0",
            "name": "wmo",
            "prefix": "wmo",
            "url": "http:\/\/icoads.noaa.gov\/metadata\/wmo47\/wmo_quarterly\/47CodeTables9903.html"
        },
        {
            "description": "Cached, accessed: 2017-05-11, via: https:\/\/web.archive.org\/web\/20111028163611\/http:\/\/developer.yahoo.com\/geo\/geoplanet\/data\/.",
            "fullname": "Yahoo! GeoPlanet (formerly Where On Earth)",
            "id": 404734187,
            "key": "id",
            "license": "http:\/\/developer.yahoo.com\/geo\/geoplanet\/data\/",
            "license_text": "This page provides open access to the underlying data under a Creative Commons Attribution license so that you can incorporate WOEIDs and the GeoPlanet hierarchy into your own applications.",
            "license_type": "CC BY",
            "name": "whereonearth",
            "prefix": "woe",
            "url": "http:\/\/developer.yahoo.com\/geo\/geoplanet\/"
        },
        {
            "description": "Clickable database of Where On Earth (woe) ids.",
            "fullname": "WOE DB",
            "id": 404734207,
            "key": "id",
            "license": "N\/A",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "woedb",
            "prefix": "woedb",
            "url": "http:\/\/woe.spum.org\/"
        },
        {
            "description": "Who's On First is a gazetteer of places. Not quite all the places in the world but a whole lot of them and, we hope, the kinds of places that we mostly share in common.",
            "fullname": "Who's On First",
            "id": 404734215,
            "key": "id",
            "license": "https:\/\/github.com\/whosonfirst-data\/whosonfirst-data\/blob\/master\/LICENSE.md",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission. Note that some included work is available under CC BY.",
            "license_type": "CC0",
            "name": "whosonfirst",
            "prefix": "wof",
            "url": "http:\/\/whosonfirst.mapzen.com\/"
        },
        {
            "description": "The source for this property is missing. For example, if a record in Who's On First was imported without a src:geom property, the source would be considered 'missing'.",
            "fullname": "Missing",
            "id": 404734213,
            "key": "",
            "license": "N\/A",
            "license_text": "N\/A",
            "license_type": "N\/A",
            "name": "missing",
            "prefix": "xx",
            "url": "N\/A"
        },
        {
            "description": "Weighted means from Quattroshapes. Yerbashapes are a product of Mapzen for Who's On First.",
            "fullname": "Yerbashapes",
            "id": 404734201,
            "key": "",
            "license": "N\/A",
            "license_text": "The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.",
            "license_type": "CC0",
            "name": "yerbashapes",
            "prefix": "ys",
            "url": ""
        },
        {
            "description": "An overlay of boundaries for Chicago's 228 neighborhoods.",
            "fullname": "Zolk Chicago Neighborhoods Map",
            "id": 907219099,
            "key": "",
            "license": "http:\/\/chicagomap.zolk.com\/about.html",
            "license_text": "The resulting KML source data is licensed under a Creative Commons Attribution License. This means that you're free to use the data from this map as you wish, but credit to either Kevin Zolkiewicz or this web site is appreciated.",
            "license_type": "CC BY 3.0 US",
            "name": "zolk",
            "prefix": "zolk",
            "url": "http:\/\/chicagomap.zolk.com\/"
        },
        {
            "description": "Zetashapes is an experiment in crowdsourced US neighborhood polygons.",
            "fullname": "Zetashapes",
            "id": 404734191,
            "key": "id",
            "license": "http:\/\/www.zetashapes.com\/license",
            "license_text": "The polygons generated by this site do not have any added restrictions beyond the base data from tiger and flickr. The basic source data is from US TIGER\/Line Census Data which is public domain (Q10). This site also makes use of data scraped from the flickr api -- you should probably mention on your site if you reuse this data that there is flickr data associated with it.",
            "license_type": "Public domain",
            "name": "zetashapes",
            "prefix": "zs",
            "remarks": "https:\/\/github.com\/whosonfirst\/whosonfirst-sources\/blob\/master\/sources\/zetashapes_remarks.md",
            "url": "http:\/\/www.zetashapes.com"
        }
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.sources.getPrefixes"></a>
#### mapzen.places.sources.getPrefixes

Return the list of prefixes for all Who&#039;s On First sources.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.sources.getPrefixes&api_key=your-mapzen-api-key'

{
    "prefixes": [
        "4sq",
        "acgov",
        "acme",
        "addr",
        "amsgis",
        "arg-caba",
        "atgov",
        "atldpcd",
        "ausstat",
        "austriaod",
        "azavea",
        "baltomoit",
        "begov",
        "bj",
        "bra",
        "btv",
        "camgov",
        "can-abog",
        "can-bbygov",
        "can-calcai",
        "can-dnvgov",
        "can-edmdsd",
        "can-gatsudd",
        "can-lvlsu",
        "can-mtlsmvt",
        "can-nwds",
        "can-ons",
        "can-qcodp",
        "can-rodca",
        "can-saskodp",
        "can-surgis",
        "can-vicodc",
        "can-wpgppd",
        "canvec-hydro",
        "cbsnl",
        "chgov",
        "companieshouse",
        "dbp",
        "denvercpd",
        "dial",
        "ds",
        "ebc",
        "edtf",
        "esp-aytomad",
        "esp-cartobcn",
        "faa",
        "fb",
        "fct",
        "fifa",
        "figov",
        "fips",
        "frgov",
        "gaul",
        "gec",
        "geom",
        "gn",
        "gp",
        "hasc",
        "hkigis",
        "hsgov",
        "iata",
        "icao",
        "inegi",
        "ioc",
        "iso",
        "itu",
        "kuogov",
        "lacity",
        "lacity_oof",
        "latimes",
        "lbl",
        "lieu",
        "loc",
        "localwiki",
        "m49",
        "marc",
        "meso",
        "ms",
        "mt",
        "mz",
        "mzb",
        "name",
        "ne",
        "ni",
        "nolagis",
        "nycgov",
        "nycgov_dca",
        "nycgov_dohmh",
        "nycgov_subway",
        "nyt",
        "oa",
        "oakced",
        "os",
        "osm",
        "oulugov",
        "out",
        "pedia",
        "porbps",
        "qs",
        "qs_pg",
        "santabar",
        "sdgis",
        "seagv",
        "sfac",
        "sfgov",
        "sfgov_rbl",
        "sg",
        "sjp",
        "smcgov",
        "ssuberlin",
        "statcan",
        "statoids",
        "stpaulgov",
        "svn-sma",
        "tgn",
        "thelist",
        "tkugov",
        "tmpgov",
        "torsdfa",
        "transitland",
        "uncrt",
        "unknown",
        "unlc",
        "uscensus",
        "uszcta",
        "vanpds",
        "wapo",
        "wd",
        "wk",
        "wmo",
        "woe",
        "woedb",
        "wof",
        "xx",
        "ys",
        "zolk",
        "zs"
    ],
    "stat": "ok"
}
```


### mapzen.places.tags

* [mapzen.places.tags.getSources](#mapzen.places.tags.getSources)
* [mapzen.places.tags.getTags](#mapzen.places.tags.getTags)

<a name="mapzen.places.tags.getSources"></a>
#### mapzen.places.tags.getSources

Return the list of sources for all the tags in Who&#039;s On First.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.tags.getSources&api_key=your-mapzen-api-key'

{
    "sources": [
        "sg",
        "wof"
    ],
    "stat": "ok"
}
```

<a name="mapzen.places.tags.getTags"></a>
#### mapzen.places.tags.getTags

Return the list of unique tags n Who&#039;s On First.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | your-mapzen-api-key | yes |
| `source` | Limit results to categories from this source. |  wof | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid source |
| `513` | Unable to retrieve tags |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.tags.getTags&api_key=your-mapzen-api-key&source=wof&per_page=1'

{
    "tags": [
        {
            "count": 837015,
            "tag": "contractor"
        }
    ],
    "next_query": "method=mapzen.places.tags.getTags&source=wof&per_page=1&page=2",
    "total": 39773,
    "page": 1,
    "per_page": 1,
    "pages": 39773,
    "cursor": null,
    "stat": "ok"
}
```


