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
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.errors&api_key=mapzen-XXXXXXX'

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
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.formats&api_key=mapzen-XXXXXXX'

{
    "formats": [
        "chicken",
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
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.methods&api_key=mapzen-XXXXXXX'

{
    "methods": [
        {
            "name": "whosonfirst.concordances.getById",
            "method": "GET",
            "description": "Return a Who's On First record (and all its concordances) by another source identifier.",
            "requires_auth": 0,
            "parameters": [
                {
                    "name": "id",
                    "description": "The ID of concordance you are looking for",
                    "required": 1,
                    "example": "3534"
                },
                {
                    "name": "source",
                    "description": "The source prefix of the concordance you are looking for",
                    "required": 1,
                    "example": "gp:id"
                }
            ],
            "errors": {
                "432": {
                    "message": "Missing 'id' parameter"
                },
                "433": {
                    "message": "Missing 'source' parameter"
                },
                "513": {
                    "message": "Failed to retrieve concordance"
                }
            },
            "extras": 0,
            "paginated": 1,
            "pagination": "plain",
            "disallow_formats": [
                "geojson",
                "meta"
            ]
        },
        {
            "name": "whosonfirst.concordances.getSources",
            "method": "GET",
            "description": "List all the sources that Who's On First holds hands with.",
            "requires_auth": 0,
            "parameters": [

            ],
            "errors": [

            ],
            "extras": 0,
            "paginated": 1,
            "pagination": "plain",
            "disallow_formats": [
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
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.test.echo&api_key=mapzen-XXXXXXX'

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
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [csv](formats.md#csv), [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.test.error&api_key=mapzen-XXXXXXX'

null
```


### whosonfirst.concordances

* [whosonfirst.concordances.getById](#whosonfirst.concordances.getById)
* [whosonfirst.concordances.getSources](#whosonfirst.concordances.getSources)

<a name="whosonfirst.concordances.getById"></a>
#### whosonfirst.concordances.getById

Return a Who&#039;s On First record (and all its concordances) by another source identifier.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `id` | The ID of concordance you are looking for |  3534 | yes |
| `source` | The source prefix of the concordance you are looking for |  gp:id | yes |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.concordances.getById&api_key=mapzen-XXXXXXX&id=3534&source=gp:id&per_page=1'

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

<a name="whosonfirst.concordances.getSources"></a>
#### whosonfirst.concordances.getSources

List all the sources that Who&#039;s On First holds hands with.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.concordances.getSources&api_key=mapzen-XXXXXXX&per_page=1'

{
    "sources": [
        {
            "source": "sg:id",
            "concordances": 21674066
        }
    ],
    "next_query": "method=whosonfirst.concordances.getSources&per_page=1&page=2",
    "total": 25,
    "page": 1,
    "per_page": 1,
    "pages": 25,
    "cursor": null,
    "stat": "ok"
}
```


### whosonfirst.pelias

* [whosonfirst.pelias.search](#whosonfirst.pelias.search)

<a name="whosonfirst.pelias.search"></a>
#### whosonfirst.pelias.search

Query Who&#039;s On First using the Pelias API

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
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
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.pelias.search&api_key=mapzen-XXXXXXX&text=JFK&size=10&layers=borough&boundary.rect.min_lat=25.84&boundary.rect.min_lon=-106.65&boundary.rect.max_lat=36.5&boundary.rect.max_lon=-93.51&boundary.country=ch&q=JFK&placetype=neighbourhood&iso=fr&min_latitude=25.84&min_longitude=-106.65&max_latitude=36.5&max_longitude=-93.51&query_field=alt&per_page=1'

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


### whosonfirst.places

* [whosonfirst.places.getByLatLon](#whosonfirst.places.getByLatLon)
* [whosonfirst.places.getDescendants](#whosonfirst.places.getDescendants)
* [whosonfirst.places.getHierarchiesByLatLon](#whosonfirst.places.getHierarchiesByLatLon)
* [whosonfirst.places.getInfo](#whosonfirst.places.getInfo)
* [whosonfirst.places.getInfoMulti](#whosonfirst.places.getInfoMulti)
* [whosonfirst.places.getIntersects](#whosonfirst.places.getIntersects)
* [whosonfirst.places.getNearby](#whosonfirst.places.getNearby)
* [whosonfirst.places.getParentByLatLon](#whosonfirst.places.getParentByLatLon) _experimental_
* [whosonfirst.places.getRandom](#whosonfirst.places.getRandom)
* [whosonfirst.places.search](#whosonfirst.places.search)

<a name="whosonfirst.places.getByLatLon"></a>
#### whosonfirst.places.getByLatLon

Return Who&#039;s On First places intersecting a latitude and longitude

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `latitude` | A valid latitude coordinate. |  37.766633 | yes |
| `longitude` | A valid longitude coordinate. |  -122.417693 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getByLatLon&api_key=mapzen-XXXXXXX&latitude=37.766633&longitude=-122.417693&placetype=neighbourhood'

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

<a name="whosonfirst.places.getDescendants"></a>
#### whosonfirst.places.getDescendants

Return all the descendants for a Who&#039;s On First ID.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `id` | A valid Who&#039;s On First ID |  420780703 | yes |
| `name` | Query for this value in the wof:name field. |  Gowanus Heights | no |
| `names` | Query for this value across all name related fields. |  SF | no |
| `alt` | Query for this value across all alternate name related fields (variant, colloquial, unknown). |  Paris | no |
| `preferred` | Query for this value across all preferred name related fields. |  বেইজিং | no |
| `variant` | Query for this value across all variant name related fields. |  💩 | no |
| `placetype` | Ensure records match this placetype. |  microhood | no |
| `tags` | Query for places with one or more of these tags. |  diner | no |
| `iso` | Ensure places belong to this (ISO) country code. |  CA | no |
| `country_id` | Ensure places belong to this country Who&#039;s On First ID. |  85633147 | no |
| `region_id` | Ensure places belong to this region Who&#039;s On First ID. |  85669831 | no |
| `locality_id` | Ensure places belong to this locality Who&#039;s On First ID. |  101736545 | no |
| `neighbourhood_id` | Ensure places belong to this neighbourhood Who&#039;s On First ID. |  102112179 | no |
| `concordance` | Query for places that have been concordified with this source. |  loc:id | no |
| `exclude` | Exclude places matching these criteria. |  nullisland | no |
| `include` | Include places matching these criteria. |  deprecated | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. | _cXVl...c7MDs=_ | no |
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](pagination.md) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getDescendants&api_key=mapzen-XXXXXXX&id=420780703&per_page=1'

{
    "places": [
        {
            "wof:id": 219976921,
            "wof:parent_id": "420780703",
            "wof:name": "Paula Frazier Handwoven",
            "wof:placetype": "venue",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data-venue-us-ca"
        }
    ],
    "next_query": "method=whosonfirst.places.getDescendants&id=420780703&per_page=1&cursor=cXVlcnlUaGVuRmV0Y2g7NTsxNDg0MTk4OnhLQTlXdk82UXN5OTJVZExLNlh5Mnc7MTQ4NDIxNTpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzE0ODQxOTc6eEtBOVd2TzZRc3k5MlVkTEs2WHkydzsxNDg0MTk5OnhLQTlXdk82UXN5OTJVZExLNlh5Mnc7MTQ4NDIxNjpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzA7",
    "total": 74,
    "page": null,
    "pages": 74,
    "per_page": 1,
    "cursor": "cXVlcnlUaGVuRmV0Y2g7NTsxNDg0MTk4OnhLQTlXdk82UXN5OTJVZExLNlh5Mnc7MTQ4NDIxNTpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzE0ODQxOTc6eEtBOVd2TzZRc3k5MlVkTEs2WHkydzsxNDg0MTk5OnhLQTlXdk82UXN5OTJVZExLNlh5Mnc7MTQ4NDIxNjpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzA7",
    "stat": "ok"
}
```

<a name="whosonfirst.places.getHierarchiesByLatLon"></a>
#### whosonfirst.places.getHierarchiesByLatLon

Return the closest set of ancestors (hierarchies) for a latitude and longitude

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `latitude` | A valid latitude coordinate. |  37.777228 | yes |
| `longitude` | A valid longitude coordinate. |  -122.470779 | yes |
| `placetype` | Skip descendants of this placetype. |  region | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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

* This method differs from whosonfirst.places.getByLatLon method in two ways: 1. It returns a list of hierarchies rather than a WOF place record and 2. It will travel up the hierarchy until an ancestor is found. For example even if there is no locality matching a given lat, lon the code will try again looking for a matching region, and so on.
* The following output formats are **disallowed** for this API method: [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getHierarchiesByLatLon&api_key=mapzen-XXXXXXX&latitude=37.777228&longitude=-122.470779&placetype=region'

{
    "hierarchies": [
        {
            "continent_id": 102191575,
            "country_id": 85633793,
            "region_id": 85688637
        }
    ],
    "stat": "ok"
}
```

<a name="whosonfirst.places.getInfo"></a>
#### whosonfirst.places.getInfo

Return a Who&#039;s On First record by ID.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `id` | A valid Who&#039;s On First ID. |  420561633 | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `513` | Unable to retrieve place |


##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getInfo&api_key=mapzen-XXXXXXX&id=420561633'

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

<a name="whosonfirst.places.getInfoMulti"></a>
#### whosonfirst.places.getInfoMulti

Return multiple Who&#039;s On First records by ID.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `ids` | A comma separated list of valid Who&#039;s On First ID. A maximum of 20 WOF IDs may be specified. |  101712565,101712563 | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;ids&#039; parameter |
| `433` | Maximum number of WOF IDs exceeded |
| `513` | Unable to retrieve places |


##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getInfoMulti&api_key=mapzen-XXXXXXX&ids=101712565,101712563'

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

<a name="whosonfirst.places.getIntersects"></a>
#### whosonfirst.places.getIntersects

Return all the Who&#039;s On First places intersecting a bounding box.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `min_latitude` | A valid latitude coordinate, representing the bottom (Southern) edge of the bounding box. |  37.78807088 | yes |
| `min_longitude` | A valid longitude coordinate, representing the left (Western) edge of the bounding box. |  -122.34374508 | yes |
| `max_latitude` | A valid latitude coordinate, representing the top (Northern) edge of the bounding box. |  37.85749665 | yes |
| `max_longitude` | A valid longitude coordinate, representing the right (Eastern) edge of the bounding box. |  -122.25585446 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  locality | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](pagination.md) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getIntersects&api_key=mapzen-XXXXXXX&min_latitude=37.78807088&min_longitude=-122.34374508&max_latitude=37.85749665&max_longitude=-122.25585446&placetype=locality&per_page=1'

{
    "places": [
        {
            "wof:id": 85922583,
            "wof:parent_id": 102087579,
            "wof:name": "San Francisco",
            "wof:placetype": "locality",
            "wof:country": "US",
            "wof:repo": "whosonfirst-data"
        }
    ],
    "next_query": "method=whosonfirst.places.getIntersects&min_latitude=37.78807088&min_longitude=-122.34374508&max_latitude=37.85749665&max_longitude=-122.25585446&placetype=locality&per_page=1&cursor=6",
    "per_page": 1,
    "cursor": 6,
    "stat": "ok"
}
```

<a name="whosonfirst.places.getNearby"></a>
#### whosonfirst.places.getNearby

Return all the Who&#039;s On First records near a point.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `latitude` | A valid latitude coordinate. |  40.784165 | yes |
| `longitude` | A valid longitude coordinate. |  -73.958110 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  venue | no |
| `radius` | A valid radius (in meters) to limit the query by. Default radius is 100. Maximum radius is 500. |  25 | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](pagination.md) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getNearby&api_key=mapzen-XXXXXXX&latitude=40.784165&longitude=-73.958110&placetype=venue&radius=25&per_page=1'

{
    "places": [

    ],
    "next_query": null,
    "total": null,
    "page": null,
    "per_page": 1,
    "pages": null,
    "cursor": null,
    "stat": "ok"
}
```

<a name="whosonfirst.places.getParentByLatLon"></a>
#### whosonfirst.places.getParentByLatLon

Return Who&#039;s On First parent ID for a latitude and longitude and placetype

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `latitude` | A valid latitude coordinate. |  35.655065 | yes |
| `longitude` | A valid longitude coordinate. |  139.369640 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getParentByLatLon&api_key=mapzen-XXXXXXX&latitude=35.655065&longitude=139.369640&placetype=neighbourhood'

{
    "place": {
        "wof:parent_id": 102031773
    },
    "stat": "ok"
}
```

<a name="whosonfirst.places.getRandom"></a>
#### whosonfirst.places.getRandom

Return a random Who&#039;s On First record.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `513` | Unable to retrieve random place. |


##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getRandom&api_key=mapzen-XXXXXXX'

{
    "place": {
        "wof:id": 421176527,
        "wof:parent_id": "85671967",
        "wof:name": "Port-au-Prince",
        "wof:placetype": "locality",
        "wof:country": "HT",
        "wof:repo": "whosonfirst-data"
    },
    "stat": "ok"
}
```

<a name="whosonfirst.places.search"></a>
#### whosonfirst.places.search

Query for Who&#039;s On First records.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `q` | Query for this value across all fields. |  poutine | no |
| `name` | Query for this value in the wof:name field. |  Gowanus Heights | no |
| `names` | Query for this value across all name related fields. |  SF | no |
| `alt` | Query for this value across all alternate name related fields (variant, colloquial, unknown). |  Paris | no |
| `preferred` | Query for this value across all preferred name related fields. |  বেইজিং | no |
| `variant` | Query for this value across all variant name related fields. |  💩 | no |
| `placetype` | Ensure records match this placetype. |  microhood | no |
| `tags` | Query for places with one or more of these tags. |  diner | no |
| `iso` | Ensure places belong to this (ISO) country code. |  CA | no |
| `country_id` | Ensure places belong to this country Who&#039;s On First ID. |  85633147 | no |
| `region_id` | Ensure places belong to this region Who&#039;s On First ID. |  85669831 | no |
| `locality_id` | Ensure places belong to this locality Who&#039;s On First ID. |  101736545 | no |
| `neighbourhood_id` | Ensure places belong to this neighbourhood Who&#039;s On First ID. |  102112179 | no |
| `concordance` | Query for places that have been concordified with this source. |  loc:id | no |
| `exclude` | Exclude places matching these criteria. |  nullisland | no |
| `include` | Include places matching these criteria. |  deprecated | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. | _cXVl...c7MDs=_ | no |
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](pagination.md) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `513` | Unable to perform search |

##### Notes

* This API method uses [mixed](pagination.md#mixed) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](pagination.md) for details.
* Please note that this method _is not a geocoder_. We already have one of those [and you should use that](https://mapzen.com/documentation/search/) instead if geocoding a string is what you're after.

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.search&api_key=mapzen-XXXXXXX&q=poutine&per_page=1'

{
    "places": [
        {
            "wof:id": 975139507,
            "wof:parent_id": "-1",
            "wof:name": "Poutine Restau-Bar Enr",
            "wof:placetype": "venue",
            "wof:country": "CA",
            "wof:repo": "whosonfirst-data-venue-ca"
        }
    ],
    "next_query": "method=whosonfirst.places.search&q=poutine&per_page=1&cursor=cXVlcnlUaGVuRmV0Y2g7NTsxNDg0MjMyOktDbXJZZ0pPUmtDU3BOaERYYnNYV1E7MTQ4NDIzMzpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzE0ODQyMzQ6S0NtcllnSk9Sa0NTcE5oRFhic1hXUTsxNDg0MjM2OktDbXJZZ0pPUmtDU3BOaERYYnNYV1E7MTQ4NDIzNTpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzA7",
    "total": 13,
    "page": null,
    "pages": 13,
    "per_page": 1,
    "cursor": "cXVlcnlUaGVuRmV0Y2g7NTsxNDg0MjMyOktDbXJZZ0pPUmtDU3BOaERYYnNYV1E7MTQ4NDIzMzpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzE0ODQyMzQ6S0NtcllnSk9Sa0NTcE5oRFhic1hXUTsxNDg0MjM2OktDbXJZZ0pPUmtDU3BOaERYYnNYV1E7MTQ4NDIzNTpLQ21yWWdKT1JrQ1NwTmhEWGJzWFdROzA7",
    "stat": "ok"
}
```


### whosonfirst.placetypes

* [whosonfirst.placetypes.getInfo](#whosonfirst.placetypes.getInfo)
* [whosonfirst.placetypes.getList](#whosonfirst.placetypes.getList)
* [whosonfirst.placetypes.getRoles](#whosonfirst.placetypes.getRoles)

<a name="whosonfirst.placetypes.getInfo"></a>
#### whosonfirst.placetypes.getInfo

Return details for a Who&#039;s On First placetype.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `id` | A valid Who&#039;s On First placetype ID. |  102322043 | no |
| `name` | A valid Who&#039;s On First placetype name. |  disputed | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getInfo&api_key=mapzen-XXXXXXX&id=102322043&name=disputed'

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

<a name="whosonfirst.placetypes.getList"></a>
#### whosonfirst.placetypes.getList

Return a list of Who&#039;s On First placetypes.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `role` | Only return placetypes that are part of this role. |  common | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid role |

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getList&api_key=mapzen-XXXXXXX&role=common'

{
    "placetypes": [
        {
            "id": 102312307,
            "name": "country",
            "parents": [
                "empire",
                "continent"
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
        }
    ],
    "stat": "ok"
}
```
_This example response has been truncated for the sake of brevity._

<a name="whosonfirst.placetypes.getRoles"></a>
#### whosonfirst.placetypes.getRoles

Return a list of Who&#039;s On First placetype roles.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getRoles&api_key=mapzen-XXXXXXX'

{
    "roles": [
        "optional",
        "common_optional",
        "common"
    ],
    "stat": "ok"
}
```


### whosonfirst.repos

* [whosonfirst.repos.getByLatLon](#whosonfirst.repos.getByLatLon)

<a name="whosonfirst.repos.getByLatLon"></a>
#### whosonfirst.repos.getByLatLon

Return a Who&#039;s On First repo name for a latitude and longitude.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `latitude` | A valid latitude coordinate. |  37.766633 | yes |
| `longitude` | A valid longitude coordinate. |  -122.417693 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  venue | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.repos.getByLatLon&api_key=mapzen-XXXXXXX&latitude=37.766633&longitude=-122.417693&placetype=venue'

{
    "repo": "whosonfirst-data-venue-us-ca",
    "url": "https:\/\/github.com\/whosonfirst-data\/whosonfirst-data-venue-us-ca",
    "stat": "ok"
}
```


### whosonfirst.sources

* [whosonfirst.sources.getInfo](#whosonfirst.sources.getInfo)
* [whosonfirst.sources.getList](#whosonfirst.sources.getList)
* [whosonfirst.sources.getPrefixes](#whosonfirst.sources.getPrefixes)

<a name="whosonfirst.sources.getInfo"></a>
#### whosonfirst.sources.getInfo

Return details for a Who&#039;s On First source.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `id` | A valid Who&#039;s On First source ID. |  840464301 | no |
| `prefix` | A valid Who&#039;s On First source prefix. |  loc | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getInfo&api_key=mapzen-XXXXXXX&id=840464301&prefix=loc'

{
    "source": {
        "fullname": "Library of Congress",
        "id": 840464301,
        "key": "id",
        "license": "https:\/\/www.usa.gov\/government-works",
        "name": "loc",
        "prefix": "loc",
        "url": "http:\/\/www.loc.gov"
    },
    "stat": "ok"
}
```

<a name="whosonfirst.sources.getList"></a>
#### whosonfirst.sources.getList

Return the list of Who&#039;s On First sources.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getList&api_key=mapzen-XXXXXXX'

{
    "sources": [
        {
            "description": "",
            "fullname": "Foursquare",
            "id": 857075439,
            "key": "id",
            "license": "",
            "name": "foursquare",
            "prefix": "4sq",
            "url": "http:\/\/www.foursquare.com"
        },
        {
            "description": "",
            "fullname": "Alameda County Data Sharing Initiative",
            "id": 874397693,
            "key": "",
            "license": "https:\/\/data.acgov.org\/terms-of-use",
            "name": "acgov",
            "prefix": "acgov",
            "url": "https:\/\/data.acgov.org\/"
        }
    ],
    "stat": "ok"
}
```
_This example response has been truncated for the sake of brevity._

<a name="whosonfirst.sources.getPrefixes"></a>
#### whosonfirst.sources.getPrefixes

Return the list of prefixes for all Who&#039;s On First sources.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getPrefixes&api_key=mapzen-XXXXXXX'

{
    "prefixes": [
        "4sq",
        "acgov",
        "addr",
        "amsgis",
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
        "can-bbygov",
        "can-dnvgov",
        "can-mtlsmvt",
        "can-nwds",
        "can-surgis",
        "cbsnl",
        "chgov",
        "dbp",
        "denvercpd",
        "edtf",
        "faa",
        "fb",
        "fct",
        "figov",
        "fips",
        "frgov",
        "geom",
        "gn",
        "gp",
        "hasc",
        "hkigis",
        "hsgov",
        "iata",
        "icao",
        "iso",
        "kuogov",
        "lacity",
        "loc",
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
        "nyt",
        "oa",
        "oakced",
        "os",
        "oulugov",
        "out",
        "pedia",
        "porbps",
        "qs",
        "sdgis",
        "seagv",
        "sfac",
        "sfgov",
        "sg",
        "sjp",
        "smcgov",
        "ssuberlin",
        "statcan",
        "stpaulgov",
        "svn-sma",
        "tgn",
        "tkugov",
        "tmpgov",
        "torsdfa",
        "transitland",
        "tz",
        "unknown",
        "unlc",
        "uscensus",
        "uszcta",
        "vanpds",
        "wapo",
        "wd",
        "wk",
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


### whosonfirst.tags

* [whosonfirst.tags.getSources](#whosonfirst.tags.getSources)
* [whosonfirst.tags.getTags](#whosonfirst.tags.getTags)

<a name="whosonfirst.tags.getSources"></a>
#### whosonfirst.tags.getSources

Return the list of sources for all the tags in Who&#039;s On First.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

##### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

##### Notes

* The following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta)

##### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.tags.getSources&api_key=mapzen-XXXXXXX'

{
    "sources": [
        "sg",
        "wof"
    ],
    "stat": "ok"
}
```

<a name="whosonfirst.tags.getTags"></a>
#### whosonfirst.tags.getTags

Return the list of unique tags n Who&#039;s On First.

##### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXXXXX | yes |
| `source` | Limit results to categories from this source. |  wof | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [chicken](formats.md#chicken), [csv](formats.md#csv), [geojson](formats.md#geojson), [json](formats.md#json), [meta](formats.md#meta) however the following output formats are **disallowed** for this API method: [geojson](formats.md#geojson), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

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
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.tags.getTags&api_key=mapzen-XXXXXXX&source=wof&per_page=1'

{
    "tags": [
        {
            "count": 837015,
            "tag": "contractor"
        }
    ],
    "next_query": "method=whosonfirst.tags.getTags&source=wof&per_page=1&page=2",
    "total": 39639,
    "page": 1,
    "per_page": 1,
    "pages": 39639,
    "cursor": null,
    "stat": "ok"
}
```


