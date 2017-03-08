## API methods

#### api.spec

* [api.spec.formats](#api.spec.formats)
* [api.spec.methods](#api.spec.methods)
#### test

* [test.echo](#test.echo)
* [test.error](#test.error)
#### whosonfirst.concordances

* [whosonfirst.concordances.getById](#whosonfirst.concordances.getById)
* [whosonfirst.concordances.getSources](#whosonfirst.concordances.getSources)
#### whosonfirst.places

* [whosonfirst.places.getByLatLon](#whosonfirst.places.getByLatLon)
* [whosonfirst.places.getDescendants](#whosonfirst.places.getDescendants)
* [whosonfirst.places.getHierarchiesByLatLon](#whosonfirst.places.getHierarchiesByLatLon)
* [whosonfirst.places.getInfo](#whosonfirst.places.getInfo)
* [whosonfirst.places.getIntersects](#whosonfirst.places.getIntersects)
* [whosonfirst.places.getNearby](#whosonfirst.places.getNearby)
* [whosonfirst.places.getParentByLatLon](#whosonfirst.places.getParentByLatLon) _experimental_
* [whosonfirst.places.getRandom](#whosonfirst.places.getRandom)
* [whosonfirst.places.search](#whosonfirst.places.search)
#### whosonfirst.placetypes

* [whosonfirst.placetypes.getInfo](#whosonfirst.placetypes.getInfo)
* [whosonfirst.placetypes.getList](#whosonfirst.placetypes.getList)
* [whosonfirst.placetypes.getRoles](#whosonfirst.placetypes.getRoles)
#### whosonfirst.sources

* [whosonfirst.sources.getInfo](#whosonfirst.sources.getInfo)
* [whosonfirst.sources.getList](#whosonfirst.sources.getList)
* [whosonfirst.sources.getPrefixes](#whosonfirst.sources.getPrefixes)
#### whosonfirst.tags

* [whosonfirst.tags.getSources](#whosonfirst.tags.getSources)
* [whosonfirst.tags.getTags](#whosonfirst.tags.getTags)

<a name="api.spec.formats"></a>
### api.spec.formats

Return the list of valid API response formats, including the default format

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.formats&api_key=API_KEY'
```


<a name="api.spec.methods"></a>
### api.spec.methods

Return the list of available API response methods.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.methods&api_key=API_KEY'
```


<a name="test.echo"></a>
### test.echo

A testing method which echo&#039;s all parameters back in the response.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=test.echo&api_key=API_KEY'
```


<a name="test.error"></a>
### test.error

Return a test error from the API

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=test.error&api_key=API_KEY'
```


<a name="whosonfirst.concordances.getById"></a>
### whosonfirst.concordances.getById

Return a Who&#039;s On First record (and all its concordances) by another source identifier.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `id` | The ID of concordance you are looking for |  3534 | yes |
| `source` | The source prefix of the concordance you are looking for |  gp | yes |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `433` | Missing &#039;source&#039; parameter |
| `513` | Failed to retrieve concordance |

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.concordances.getById&api_key=API_KEY&id=ID&source=SOURCE'
```


<a name="whosonfirst.concordances.getSources"></a>
### whosonfirst.concordances.getSources

List all the sources that Who&#039;s On First holds hands with.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.concordances.getSources&api_key=API_KEY'
```


<a name="whosonfirst.places.getByLatLon"></a>
### whosonfirst.places.getByLatLon

Return Who&#039;s On First places intersecting a latitude and longitude

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `latitude` | A valid latitude coordinate. |  37.766633 | yes |
| `longitude` | A valid longitude coordinate. |  -122.417693 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](#pagination) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Invalid placetype |
| `513` | Failed to perform lookup |

#### Notes

* This method differs from the whosonfirst.places.getAncestorsByLatLon method in two ways: 1. It returns a list of WOF places rather than hierarchies and 2. If a placetype filter is specified and no matching records are found no attempt will be made to find ancestors higher up the hierarchy. For example looking for an intersecting county or region if no locality is found.
* This API method uses [cursor-based](pagination.md#cursor) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getByLatLon&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getDescendants"></a>
### whosonfirst.places.getDescendants

Return all the descendants for a Who&#039;s On First ID.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
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
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](#pagination) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `513` | Unable to retrieve descendants |

#### Notes

* This API method uses [mixed](pagination.md#mixed) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getDescendants&api_key=API_KEY&id=ID&name=NAME&names=NAMES&alt=ALT&preferred=PREFERRED&variant=VARIANT&placetype=PLACETYPE&tags=TAGS&iso=ISO&country_id=COUNTRY_ID&region_id=REGION_ID&locality_id=LOCALITY_ID&neighbourhood_id=NEIGHBOURHOOD_ID&concordance=CONCORDANCE&exclude=EXCLUDE&include=INCLUDE'
```


<a name="whosonfirst.places.getHierarchiesByLatLon"></a>
### whosonfirst.places.getHierarchiesByLatLon

Return the closest set of ancestors (hierarchies) for a latitude and longitude

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `latitude` | A valid latitude coordinate. |  37.777228 | yes |
| `longitude` | A valid longitude coordinate. |  -122.470779 | yes |
| `placetype` | Skip descendants of this placetype. |  region | no |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;latitude&#039; parameter |
| `433` | Missing &#039;longitude&#039; parameter |
| `434` | Invalid &#039;latitude&#039; parameter |
| `435` | Invalid &#039;longitude&#039; parameter |
| `436` | Invalid placetype |
| `513` | Failed to perform lookup |

#### Notes

* This method differs from whosonfirst.places.getByLatLon method in two ways: 1. It returns a list of hierarchies rather than a WOF place record and 2. It will travel up the hierarchy until an ancestor is found. For example even if there is no locality matching a given lat, lon the code will try again looking for a matching region, and so on.
* The following output formats are <span class="hey-look">disallowed</span> for this API method: [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getHierarchiesByLatLon&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getInfo"></a>
### whosonfirst.places.getInfo

Return a Who&#039;s On First record by ID.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `id` | A valid Who&#039;s On First ID. |  420561633 | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Missing &#039;id&#039; parameter |
| `513` | Unable to retrieve place |



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getInfo&api_key=API_KEY&id=ID'
```


<a name="whosonfirst.places.getIntersects"></a>
### whosonfirst.places.getIntersects

Return all the Who&#039;s On First places intersecting a bounding box.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `min_latitude` | A valid latitude coordinate, representing the bottom (Southern) edge of the bounding box. |  37.78807088 | yes |
| `min_longitude` | A valid longitude coordinate, representing the left (Western) edge of the bounding box. |  -122.34374508 | yes |
| `max_latitude` | A valid latitude coordinate, representing the top (Northern) edge of the bounding box. |  37.85749665 | yes |
| `max_longitude` | A valid longitude coordinate, representing the right (Eastern) edge of the bounding box. |  -122.25585446 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  locality | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](#pagination) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

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

#### Notes

* This API method uses [cursor-based](pagination.md#cursor) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getIntersects&api_key=API_KEY&min_latitude=MIN_LATITUDE&min_longitude=MIN_LONGITUDE&max_latitude=MAX_LATITUDE&max_longitude=MAX_LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getNearby"></a>
### whosonfirst.places.getNearby

Return all the Who&#039;s On First records near a point.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `latitude` | A valid latitude coordinate. |  40.784165 | yes |
| `longitude` | A valid longitude coordinate. |  -73.958110 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  venue | no |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `cursor` | This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the `cursor` property. Please consult the [pagination documentation](#pagination) for details. | _cXVl...c7MDs=_ | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

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

#### Notes

* This API method uses [cursor-based](pagination.md#cursor) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getNearby&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getParentByLatLon"></a>
### whosonfirst.places.getParentByLatLon

Return Who&#039;s On First parent ID for a latitude and longitude and placetype

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `latitude` | A valid latitude coordinate. |  35.655065 | yes |
| `longitude` | A valid longitude coordinate. |  139.369640 | yes |
| `placetype` | A valid Who&#039;s On First placetype to limit the query by. |  neighbourhood | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

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

#### Notes

* The inability to locate (or to disambiguate) a parent ID for a lat, lon will not trigger an API error. The following parent IDs may be returned by this API method: &#039;-1&#039; which means that a parent ID could not be identified or that there are multiple choices; or &#039;-3&#039; which means that the parent is a neighbourhood and their are multiple possible choices and you should go out for a beer and argue over which is the correct parent.
* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)
* This API method is <span class="hey-look">experimental</span>. Both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getParentByLatLon&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getRandom"></a>
### whosonfirst.places.getRandom

Return a random Who&#039;s On First record.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `extras` | A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`) | mz:uri | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `513` | Unable to retrieve random place. |



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getRandom&api_key=API_KEY'
```


<a name="whosonfirst.places.search"></a>
### whosonfirst.places.search

Query for Who&#039;s On First records.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
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
| `page` | The default is 1. If this API method returns a non-empty `cursor` property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the `next_query` property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](#pagination) for details. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `513` | Unable to perform search |

#### Notes

* This API method uses [mixed](pagination.md#mixed) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.search&api_key=API_KEY&q=Q&name=NAME&names=NAMES&alt=ALT&preferred=PREFERRED&variant=VARIANT&placetype=PLACETYPE&tags=TAGS&iso=ISO&country_id=COUNTRY_ID&region_id=REGION_ID&locality_id=LOCALITY_ID&neighbourhood_id=NEIGHBOURHOOD_ID&concordance=CONCORDANCE&exclude=EXCLUDE&include=INCLUDE'
```


<a name="whosonfirst.placetypes.getInfo"></a>
### whosonfirst.placetypes.getInfo

Return details for a Who&#039;s On First placetype.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `id` | A valid Who&#039;s On First placetype ID. |  102322043 | no |
| `name` | A valid Who&#039;s On First placetype name. |  disputed | no |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid place ID |
| `433` | Invalid place name |

#### Notes

* Although the &quot;id&quot; and &quot;name&quot; parameters are each marked as optional, you need to pass at least one of them. The order of precedence is &quot;id&quot; followed by &quot;name&quot;.
* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getInfo&api_key=API_KEY&id=ID&name=NAME'
```


<a name="whosonfirst.placetypes.getList"></a>
### whosonfirst.placetypes.getList

Return a list of Who&#039;s On First placetypes.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `role` | Only return placetypes that are part of this role. |  common | no |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid role |

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getList&api_key=API_KEY&role=ROLE'
```


<a name="whosonfirst.placetypes.getRoles"></a>
### whosonfirst.placetypes.getRoles

Return a list of Who&#039;s On First placetype roles.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getRoles&api_key=API_KEY'
```


<a name="whosonfirst.sources.getInfo"></a>
### whosonfirst.sources.getInfo

Return details for a Who&#039;s On First source.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `id` | A valid Who&#039;s On First source ID. |  840464301 | no |
| `prefix` | A valid Who&#039;s On First source prefix. |  loc | no |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid source ID |
| `433` | Invalid source prefix |

#### Notes

* Although the &quot;id&quot; and &quot;prefix&quot; parameters are each marked as optional, you need to pass at least one of them. The order of precedence is &quot;id&quot; followed by &quot;prefix&quot;.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getInfo&api_key=API_KEY&id=ID&prefix=PREFIX'
```


<a name="whosonfirst.sources.getList"></a>
### whosonfirst.sources.getList

Return the list of Who&#039;s On First sources.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getList&api_key=API_KEY'
```


<a name="whosonfirst.sources.getPrefixes"></a>
### whosonfirst.sources.getPrefixes

Return the list of prefixes for all Who&#039;s On First sources.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json)</a>.| json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getPrefixes&api_key=API_KEY'
```


<a name="whosonfirst.tags.getSources"></a>
### whosonfirst.tags.getSources

Return the list of sources for all the tags in Who&#039;s On First.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](errors.md) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.tags.getSources&api_key=API_KEY'
```


<a name="whosonfirst.tags.getTags"></a>
### whosonfirst.tags.getTags

Return the list of unique tags n Who&#039;s On First.

#### Arguments

| Argument | Description | Example | Required |
| :--- | :--- | :--- | :--- |
| `api_key` | A valid [Mapzen API key](https://mapzen.com/developers/) | mapzen-XXXX | yes |
| `source` | Limit results to categories from this source. |  wof | no |
| `page` | The default is 1. | 1 | no |
| `per_page` | The default is 100 and the maximum is 500. | 100 | no |
| `format` | The format in which to return the data. Normally supported formats are [json](formats.md#json), [csv](formats.md#csv), [meta](formats.md#meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta). The default format is [json](formats.md#json). | json | no |

#### Error codes

In addition to [default error codes](errors.md) common to all methods this API method defines the following additional error codes:

| Error code | Error message |
| :--- | :--- |
| `432` | Invalid source |
| `513` | Unable to retrieve tags |

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](formats.md#csv), [meta](formats.md#meta)
* This API method uses [plain](pagination.md#plain) or [next-query](pagination.md#next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.tags.getTags&api_key=API_KEY&source=SOURCE'
```


