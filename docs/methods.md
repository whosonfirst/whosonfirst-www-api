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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.concordances.getById&api_key=your-mapzen-api-key&id=ID&source=SOURCE'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.concordances.getSources&api_key=your-mapzen-api-key'
```


### mapzen.places

* [mapzen.places.getByLatLon](#mapzen.places.getByLatLon)
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getByLatLon&api_key=your-mapzen-api-key&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
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
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. |  1 | no |
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getDescendants&api_key=your-mapzen-api-key&id=ID&name=NAME&names=NAMES&alt=ALT&preferred=PREFERRED&variant=VARIANT&placetype=PLACETYPE&exclude_placetype=EXCLUDE_PLACETYPE&tags=TAGS&iso=ISO&country_id=COUNTRY_ID&region_id=REGION_ID&locality_id=LOCALITY_ID&neighbourhood_id=NEIGHBOURHOOD_ID&brand_id=BRAND_ID&concordance=CONCORDANCE&is_current=IS_CURRENT&is_ceased=IS_CEASED&is_deprecated=IS_DEPRECATED&is_superseded=IS_SUPERSEDED&is_superseding=IS_SUPERSEDING&has_brand=HAS_BRAND&exclude=EXCLUDE&include=INCLUDE&min_lastmod=MIN_LASTMOD&max_lastmod=MAX_LASTMOD'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getHierarchiesByLatLon&api_key=your-mapzen-api-key&latitude=LATITUDE&longitude=LONGITUDE&spr=SPR&placetype=PLACETYPE'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getInfo&api_key=your-mapzen-api-key&id=ID'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getInfoMulti&api_key=your-mapzen-api-key&ids=IDS'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getIntersects&api_key=your-mapzen-api-key&min_latitude=MIN_LATITUDE&min_longitude=MIN_LONGITUDE&max_latitude=MAX_LATITUDE&max_longitude=MAX_LONGITUDE&placetype=PLACETYPE'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getNearby&api_key=your-mapzen-api-key&latitude=LATITUDE&longitude=LONGITUDE&radius=RADIUS&placetype=PLACETYPE'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.getParentByLatLon&api_key=your-mapzen-api-key&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
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
| `is_current` | Filter results by their &#039;mz:is_current&#039; property. |  1 | no |
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.search&api_key=your-mapzen-api-key&q=Q&name=NAME&names=NAMES&alt=ALT&preferred=PREFERRED&variant=VARIANT&placetype=PLACETYPE&exclude_placetype=EXCLUDE_PLACETYPE&tags=TAGS&iso=ISO&country_id=COUNTRY_ID&region_id=REGION_ID&locality_id=LOCALITY_ID&neighbourhood_id=NEIGHBOURHOOD_ID&brand_id=BRAND_ID&concordance=CONCORDANCE&is_current=IS_CURRENT&is_ceased=IS_CEASED&is_deprecated=IS_DEPRECATED&is_superseded=IS_SUPERSEDED&is_superseding=IS_SUPERSEDING&has_brand=HAS_BRAND&exclude=EXCLUDE&include=INCLUDE&min_lastmod=MIN_LASTMOD&max_lastmod=MAX_LASTMOD'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.pelias.autocomplete&api_key=your-mapzen-api-key&text=TEXT'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.pelias.search&api_key=your-mapzen-api-key&text=TEXT&size=SIZE&layers=LAYERS&boundary.country=BOUNDARY.COUNTRY&q=Q&placetype=PLACETYPE&iso=ISO&query_field=QUERY_FIELD'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.placetypes.getInfo&api_key=your-mapzen-api-key&id=ID&name=NAME'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.placetypes.getList&api_key=your-mapzen-api-key&role=ROLE'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.repos.getByLatLon&api_key=your-mapzen-api-key&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
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
curl -X GET 'https://places.mapzen.com/v1/?method=mapzen.places.tags.getTags&api_key=your-mapzen-api-key&source=SOURCE'
```


