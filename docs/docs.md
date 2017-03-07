# Who's On First API Documentation

* [Introduction](#introduction)
* [API methods](#methods)
* [Response formats](#formats)
* [Pagination](#pagination)
* [Error codes](#error-codes)

<a name="intro"></a>
## Introduction

<a name="posse"></a>
![CGI has a posse](prism.gif)

_Please write me._

_Something something something "stuff over HTTP". Something something something "query parameters". Something something something "`400` class errors are your fault and `500` class errors are our fault"._

<a name="caveats"></a>
### Caveats

You should treat this API as though it were in "beta".

Which is to say: The point is for the thing to _work_ but there are probably still some rough edges and lingering gotchas so you should adjust your expectations and your code accordingly. In the meantime have at it and please let us know if something is busted or just doesn't feel right.

Also some methods are "more beta" than others. These methods are flagged as being `experimental` which means that both its inputs and outputs _may_ change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.

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

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.formats&api_key=API_KEY'
```


<a name="api.spec.methods"></a>
### api.spec.methods

Return the list of available API response methods.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=api.spec.methods&api_key=API_KEY'
```


<a name="test.echo"></a>
### test.echo

A testing method which echo&#039;s all parameters back in the response.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=test.echo&api_key=API_KEY'
```


<a name="test.error"></a>
### test.error

Return a test error from the API

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=test.error&api_key=API_KEY'
```


<a name="whosonfirst.concordances.getById"></a>
### whosonfirst.concordances.getById

Return a Who&#039;s On First record (and all its concordances) by another source identifier.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **id** _required_ &#8212; The ID of concordance you are looking for For example `3534`.
* **source** _required_ &#8212; The source prefix of the concordance you are looking for For example `gp`.
* **page** &#8212; The default is 1.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;id&#039; parameter
* `433` &#8212; Missing &#039;source&#039; parameter
* `513` &#8212; Failed to retrieve concordance

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)
* This API method uses [plain](#pagination-plain) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.concordances.getById&api_key=API_KEY&id=ID&source=SOURCE'
```


<a name="whosonfirst.concordances.getSources"></a>
### whosonfirst.concordances.getSources

List all the sources that Who&#039;s On First holds hands with.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **page** &#8212; The default is 1.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)
* This API method uses [plain](#pagination-plain) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.concordances.getSources&api_key=API_KEY'
```


<a name="whosonfirst.places.getByLatLon"></a>
### whosonfirst.places.getByLatLon

Return Who&#039;s On First places intersecting a latitude and longitude

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **latitude** _required_ &#8212; A valid latitude coordinate. For example `37.766633`.
* **longitude** _required_ &#8212; A valid longitude coordinate. For example `-122.417693`.
* **placetype**  &#8212; A valid Who&#039;s On First placetype to limit the query by. For example `neighbourhood`.
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **cursor** &#8212; This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the <code>cursor</code> property. Please consult the [pagination documentation](#pagination) for details.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;latitude&#039; parameter
* `433` &#8212; Missing &#039;longitude&#039; parameter
* `434` &#8212; Invalid &#039;latitude&#039; parameter
* `435` &#8212; Invalid &#039;longitude&#039; parameter
* `436` &#8212; Invalid placetype
* `513` &#8212; Failed to perform lookup

#### Notes

* This method differs from the whosonfirst.places.getAncestorsByLatLon method in two ways: 1. It returns a list of WOF places rather than hierarchies and 2. If a placetype filter is specified and no matching records are found no attempt will be made to find ancestors higher up the hierarchy. For example looking for an intersecting county or region if no locality is found.
* This API method uses [cursor-based](#pagination-cursor) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getByLatLon&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getDescendants"></a>
### whosonfirst.places.getDescendants

Return all the descendants for a Who&#039;s On First ID.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **id** _required_ &#8212; A valid Who&#039;s On First ID For example `420780703`.
* **name**  &#8212; Query for this value in the wof:name field. For example `Gowanus Heights`.
* **names**  &#8212; Query for this value across all name related fields. For example `SF`.
* **alt**  &#8212; Query for this value across all alternate name related fields (variant, colloquial, unknown). For example `Paris`.
* **preferred**  &#8212; Query for this value across all preferred name related fields. For example `বেইজিং`.
* **variant**  &#8212; Query for this value across all variant name related fields. For example `💩`.
* **placetype**  &#8212; Ensure records match this placetype. For example `microhood`.
* **tags**  &#8212; Query for places with one or more of these tags. For example `diner`.
* **category**  &#8212; Query for places with one or more of these categories..
* **iso**  &#8212; Ensure places belong to this (ISO) country code. For example `CA`.
* **country_id**  &#8212; Ensure places belong to this country Who&#039;s On First ID. For example `85633147`.
* **region_id**  &#8212; Ensure places belong to this region Who&#039;s On First ID. For example `85669831`.
* **locality_id**  &#8212; Ensure places belong to this locality Who&#039;s On First ID. For example `101736545`.
* **neighbourhood_id**  &#8212; Ensure places belong to this neighbourhood Who&#039;s On First ID. For example `102112179`.
* **concordance**  &#8212; Query for places that have been concordified with this source. For example `loc:id`.
* **exclude**  &#8212; Exclude places matching these criteria. For example `nullisland`.
* **include**  &#8212; Include places matching these criteria. For example `deprecated`.
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **cursor** &#8212; This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the <code>cursor</code> property.
* **page** &#8212; The default is 1. If this API method returns a non-empty <code>cursor</code> property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the <code>next_query</code> property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](#pagination) for details.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;id&#039; parameter
* `513` &#8212; Unable to retrieve descendants

#### Notes

* This API method uses [mixed](#pagination-mixed) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getDescendants&api_key=API_KEY&id=ID&name=NAME&names=NAMES&alt=ALT&preferred=PREFERRED&variant=VARIANT&placetype=PLACETYPE&tags=TAGS&category=CATEGORY&iso=ISO&country_id=COUNTRY_ID&region_id=REGION_ID&locality_id=LOCALITY_ID&neighbourhood_id=NEIGHBOURHOOD_ID&concordance=CONCORDANCE&exclude=EXCLUDE&include=INCLUDE'
```


<a name="whosonfirst.places.getHierarchiesByLatLon"></a>
### whosonfirst.places.getHierarchiesByLatLon

Return the closest set of ancestors (hierarchies) for a latitude and longitude

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **latitude** _required_ &#8212; A valid latitude coordinate. For example `37.777228`.
* **longitude** _required_ &#8212; A valid longitude coordinate. For example `-122.470779`.
* **placetype**  &#8212; Skip descendants of this placetype. For example `region`.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;latitude&#039; parameter
* `433` &#8212; Missing &#039;longitude&#039; parameter
* `434` &#8212; Invalid &#039;latitude&#039; parameter
* `435` &#8212; Invalid &#039;longitude&#039; parameter
* `436` &#8212; Invalid placetype
* `513` &#8212; Failed to perform lookup

#### Notes

* This method differs from whosonfirst.places.getByLatLon method in two ways: 1. It returns a list of hierarchies rather than a WOF place record and 2. It will travel up the hierarchy until an ancestor is found. For example even if there is no locality matching a given lat, lon the code will try again looking for a matching region, and so on.
* The following output formats are <span class="hey-look">disallowed</span> for this API method: [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getHierarchiesByLatLon&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getInfo"></a>
### whosonfirst.places.getInfo

Return a Who&#039;s On First record by ID.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **id** _required_ &#8212; A valid Who&#039;s On First ID. For example `420561633`.
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;id&#039; parameter
* `513` &#8212; Unable to retrieve place



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getInfo&api_key=API_KEY&id=ID'
```


<a name="whosonfirst.places.getIntersects"></a>
### whosonfirst.places.getIntersects

Return all the Who&#039;s On First places intersecting a bounding box.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **min_latitude** _required_ &#8212; A valid latitude coordinate, representing the bottom (Southern) edge of the bounding box. For example `37.78807088`.
* **min_longitude** _required_ &#8212; A valid longitude coordinate, representing the left (Western) edge of the bounding box. For example `-122.34374508`.
* **max_latitude** _required_ &#8212; A valid latitude coordinate, representing the top (Northern) edge of the bounding box. For example `37.85749665`.
* **max_longitude** _required_ &#8212; A valid longitude coordinate, representing the right (Eastern) edge of the bounding box. For example `-122.25585446`.
* **placetype**  &#8212; A valid Who&#039;s On First placetype to limit the query by. For example `locality`.
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **cursor** &#8212; This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the <code>cursor</code> property. Please consult the [pagination documentation](#pagination) for details.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;min_latitude&#039; parameter
* `433` &#8212; Missing &#039;min_longitude&#039; parameter
* `434` &#8212; Missing &#039;max_latitude&#039; parameter
* `435` &#8212; Missing &#039;max_longitude&#039; parameter
* `436` &#8212; Invalid &#039;min_latitude&#039; parameter
* `437` &#8212; Invalid &#039;min_longitude&#039; parameter
* `438` &#8212; Invalid &#039;max_latitude&#039; parameter
* `439` &#8212; Invalid &#039;max_longitude&#039; parameter
* `513` &#8212; Failed to intersect

#### Notes

* This API method uses [cursor-based](#pagination-cursor) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getIntersects&api_key=API_KEY&min_latitude=MIN_LATITUDE&min_longitude=MIN_LONGITUDE&max_latitude=MAX_LATITUDE&max_longitude=MAX_LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getNearby"></a>
### whosonfirst.places.getNearby

Return all the Who&#039;s On First records near a point.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **latitude** _required_ &#8212; A valid latitude coordinate. For example `40.784165`.
* **longitude** _required_ &#8212; A valid longitude coordinate. For example `-73.958110`.
* **placetype**  &#8212; A valid Who&#039;s On First placetype to limit the query by. For example `venue`.
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **cursor** &#8212; This method uses cursor-based pagination so this argument is the pointer returned by the last API response, in the <code>cursor</code> property. Please consult the [pagination documentation](#pagination) for details.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;latitude&#039; parameter
* `433` &#8212; Missing &#039;longitude&#039; parameter
* `434` &#8212; Invalid &#039;latitude&#039; parameter
* `435` &#8212; Invalid &#039;longitude&#039; parameter
* `436` &#8212; Invalid radius
* `437` &#8212; Invalid placetype
* `513` &#8212; Failed to get nearby

#### Notes

* This API method uses [cursor-based](#pagination-cursor) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getNearby&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getParentByLatLon"></a>
### whosonfirst.places.getParentByLatLon

Return Who&#039;s On First parent ID for a latitude and longitude and placetype

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **latitude** _required_ &#8212; A valid latitude coordinate. For example `35.655065`.
* **longitude** _required_ &#8212; A valid longitude coordinate. For example `139.369640`.
* **placetype** _required_ &#8212; A valid Who&#039;s On First placetype to limit the query by. For example `neighbourhood`.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Missing &#039;latitude&#039; parameter
* `433` &#8212; Missing &#039;longitude&#039; parameter
* `434` &#8212; Invalid &#039;latitude&#039; parameter
* `435` &#8212; Invalid &#039;longitude&#039; parameter
* `436` &#8212; Missing &#039;placetype&#039; parameter
* `437` &#8212; Invalid placetype
* `513` &#8212; Failed to perform lookup

#### Notes

* The inability to locate (or to disambiguate) a parent ID for a lat, lon will not trigger an API error. The following parent IDs may be returned by this API method: &#039;-1&#039; which means that a parent ID could not be identified or that there are multiple choices; or &#039;-3&#039; which means that the parent is a neighbourhood and their are multiple possible choices and you should go out for a beer and argue over which is the correct parent.
* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)
* This API method is <span class="hey-look">experimental</span>. Both its inputs and outputs <em>may</em> change without warning. We'll try not to introduce any backwards incompatible changes but you should approach this API method defensively.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getParentByLatLon&api_key=API_KEY&latitude=LATITUDE&longitude=LONGITUDE&placetype=PLACETYPE'
```


<a name="whosonfirst.places.getRandom"></a>
### whosonfirst.places.getRandom

Return a random Who&#039;s On First record.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `513` &#8212; Unable to retrieve random place.



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getRandom&api_key=API_KEY'
```


<a name="whosonfirst.places.search"></a>
### whosonfirst.places.search

Query for Who&#039;s On First records.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **q**  &#8212; Query for this value across all fields. For example `poutine`.
* **name**  &#8212; Query for this value in the wof:name field. For example `Gowanus Heights`.
* **names**  &#8212; Query for this value across all name related fields. For example `SF`.
* **alt**  &#8212; Query for this value across all alternate name related fields (variant, colloquial, unknown). For example `Paris`.
* **preferred**  &#8212; Query for this value across all preferred name related fields. For example `বেইজিং`.
* **variant**  &#8212; Query for this value across all variant name related fields. For example `💩`.
* **placetype**  &#8212; Ensure records match this placetype. For example `microhood`.
* **tags**  &#8212; Query for places with one or more of these tags. For example `diner`.
* **category**  &#8212; Query for places with one or more of these categories..
* **iso**  &#8212; Ensure places belong to this (ISO) country code. For example `CA`.
* **country_id**  &#8212; Ensure places belong to this country Who&#039;s On First ID. For example `85633147`.
* **region_id**  &#8212; Ensure places belong to this region Who&#039;s On First ID. For example `85669831`.
* **locality_id**  &#8212; Ensure places belong to this locality Who&#039;s On First ID. For example `101736545`.
* **neighbourhood_id**  &#8212; Ensure places belong to this neighbourhood Who&#039;s On First ID. For example `102112179`.
* **concordance**  &#8212; Query for places that have been concordified with this source. For example `loc:id`.
* **exclude**  &#8212; Exclude places matching these criteria. For example `nullisland`.
* **include**  &#8212; Include places matching these criteria. For example `deprecated`.
* **extras** &#8212; A comma-separated list of additional fields to include with each result. Valid fields are anything that might be found at the top level of WOF properties dictionary. You can also fetch all the fields for a given namespace by passing its prefix followed by a colon (for example `mz:`)
* **cursor** &#8212; This method sometimes uses cursor-based pagination so this argument is the pointer returned by the last API response, in the <code>cursor</code> property.
* **page** &#8212; The default is 1. If this API method returns a non-empty <code>cursor</code> property as part of its response that means you should switch to using cursor-based pagination for all subsequent queries. Alternately you can simply rely on the <code>next_query</code> property to determine which parameters to include with your next request. Unfortunately it's complicated because databases are, after all these years, still complicated. Please consult the [pagination documentation](#pagination) for details.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `513` &#8212; Unable to perform search

#### Notes

* This API method uses [mixed](#pagination-mixed) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.search&api_key=API_KEY&q=Q&name=NAME&names=NAMES&alt=ALT&preferred=PREFERRED&variant=VARIANT&placetype=PLACETYPE&tags=TAGS&category=CATEGORY&iso=ISO&country_id=COUNTRY_ID&region_id=REGION_ID&locality_id=LOCALITY_ID&neighbourhood_id=NEIGHBOURHOOD_ID&concordance=CONCORDANCE&exclude=EXCLUDE&include=INCLUDE'
```


<a name="whosonfirst.placetypes.getInfo"></a>
### whosonfirst.placetypes.getInfo

Return details for a Who&#039;s On First placetype.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **id**  &#8212; A valid Who&#039;s On First placetype ID. For example `102322043`.
* **name**  &#8212; A valid Who&#039;s On First placetype name. For example `disputed`.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Invalid place ID
* `433` &#8212; Invalid place name

#### Notes

* Although the &quot;id&quot; and &quot;name&quot; parameters are each marked as optional, you need to pass at least one of them. The order of precedence is &quot;id&quot; followed by &quot;name&quot;.
* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getInfo&api_key=API_KEY&id=ID&name=NAME'
```


<a name="whosonfirst.placetypes.getList"></a>
### whosonfirst.placetypes.getList

Return a list of Who&#039;s On First placetypes.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **role**  &#8212; Only return placetypes that are part of this role. For example `common`.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Invalid role

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getList&api_key=API_KEY&role=ROLE'
```


<a name="whosonfirst.placetypes.getRoles"></a>
### whosonfirst.placetypes.getRoles

Return a list of Who&#039;s On First placetype roles.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.placetypes.getRoles&api_key=API_KEY'
```


<a name="whosonfirst.sources.getInfo"></a>
### whosonfirst.sources.getInfo

Return details for a Who&#039;s On First source.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **id**  &#8212; A valid Who&#039;s On First source ID. For example `840464301`.
* **prefix**  &#8212; A valid Who&#039;s On First source prefix. For example `loc`.
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Invalid source ID
* `433` &#8212; Invalid source prefix

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

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getList&api_key=API_KEY'
```


<a name="whosonfirst.sources.getPrefixes"></a>
### whosonfirst.sources.getPrefixes

Return the list of prefixes for all Who&#039;s On First sources.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta). The default format is [json](#formats-json)</a>.

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.



#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.sources.getPrefixes&api_key=API_KEY'
```


<a name="whosonfirst.tags.getSources"></a>
### whosonfirst.tags.getSources

Return the list of sources for all the tags in Who&#039;s On First.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

This API method does not define any custom error codes. For the list of error codes common to all API methods please consult the [default error codes](#error-codes) documentation.

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.tags.getSources&api_key=API_KEY'
```


<a name="whosonfirst.tags.getTags"></a>
### whosonfirst.tags.getTags

Return the list of unique tags n Who&#039;s On First.

#### Arguments

* **api_key** _required_ &#8212; A valid [Mapzen API key](https://mapzen.com/developers/)
* **source**  &#8212; Limit results to categories from this source. For example `wof`.
* **page** &#8212; The default is 1.
* **per_page** &#8212; The default is 100 and the maximum is 500.
* **format** &#8212; The format in which to return the data. Normally supported formats are [json](#formats-json), [csv](#formats-csv), [meta](#formats-meta) however the following output formats are <span class="hey-look">disallowed</span> for this API method: <a href="http://fake.com/formats/csv/">csv</a>, <a href="http://fake.com/formats/meta/">meta</a>. The default format is [json](#formats-json).

#### Error codes

In addition to [default error codes](#error-codes) common to all methods this API method defines the following additional error codes:

* `432` &#8212; Invalid source
* `513` &#8212; Unable to retrieve tags

#### Notes

* The following output formats are <span class="hey-look">disallowed</span> for this API method: [csv](#formats-csv), [meta](#formats-meta)
* This API method uses [plain](#pagination-plain) or [next-query](#pagination-next-query) pagination. Please consult the [pagination documentation](#pagination) for details.


#### Example

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.tags.getTags&api_key=API_KEY&source=SOURCE'
```



<a name="formats"></a>
## Response formats

The default response format is [json](#format-json).

<a name="formats-json"></a>
### json

JSON (JavaScript Object Notation) is a data-interchange format based on JavaScript. For more details, consult <a href="http://json.org/">http://json.org/</a>.

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.search&api_key={API_KEY}&q=poutine&page=1&per_page=1&format=json'
```

#### Example response

```
< HTTP/1.1 200 OK
< Access-Control-Allow-Origin: *
< Content-Type: text/json
< Date: Tue, 28 Feb 2017 22:29:49 GMT
< Status: 200 OK
< X-api-pagination-cursor: 
< X-api-pagination-next-query: method=whosonfirst.places.search&amp;q=poutine&amp;extras=geom%3Abbox&amp;per_page=1&amp;page=2
< X-api-pagination-page: 1
< X-api-pagination-pages: 13
< X-api-pagination-per-page: 1
< X-api-pagination-total: 13
< Content-Length: 410
< Connection: keep-alive
< 
{
    "cursor": null,
    "next_query": "method=whosonfirst.places.search&q=poutine&extras=geom%3Abbox&per_page=1&page=2",
    "page": 1,
    "pages": 13,
    "per_page": 1,
    "results": [
        {
            "geom:bbox": "-71.9399642944,46.0665283203,-71.9399642944,46.0665283203",
            "wof:country": "CA",
            "wof:id": 975139507,
            "wof:name": "Poutine Restau-Bar Enr",
            "wof:parent_id": "-1",
            "wof:placetype": "venue",
            "wof:repo": "whosonfirst-data-venue-ca"
        }
    ],
    "stat": "ok",
    "total": 13
}
```

### Notes

JSON output is supported for all API methods.<a name="formats-csv"></a>
### csv

CSV (Comma Separated Value)

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.search&api_key={API_KEY}&q=poutine&page=1&per_page=1<strong>&format=csv</strong>'
```

#### Example response

```
&lt; HTTP/1.1 200 OK
&lt; Access-Control-Allow-Origin: *
&lt; Content-Type: text/csv
&lt; Date: Tue, 28 Feb 2017 21:13:37 GMT
&lt; Status: 200 OK
&lt; X-api-pagination-cursor: 
&lt; X-api-pagination-next-query: method=whosonfirst.places.search&amp;q=poutine&amp;extras=geom%3Abbox&amp;per_page=1&amp;page=2&amp;format=csv
&lt; X-api-pagination-page: 1
&lt; X-api-pagination-pages: 13
&lt; X-api-pagination-per-page: 1
&lt; X-api-pagination-total: 13
&lt; X-api-format-csv-header: geom_bbox,wof_country,wof_id,wof_name,wof_parent_id,wof_placetype,wof_repo
&lt; Content-Length: 208
&lt; Connection: keep-alive
&lt; 
geom_bbox,wof_country,wof_id,wof_name,wof_parent_id,wof_placetype,wof_repo
"-71.9399642944,46.0665283203,-71.9399642944,46.0665283203",CA,975139507,"Poutine Restau-Bar Enr",-1,venue,whosonfirst-data-venue-ca
````

<small>The CVS header is only written, in the body of the response, for the first page of API responses. The <code>X-api-format-csv-header</code> HTTP header is included with all responses.</small>

#### Notes

CSV output is not supported for all API methods.<a name="formats-meta"></a>
### meta

As in a Who's On First "meta" file. A meta file is really just a CSV file with a pre-defined set of column headers. Meta files are included with all of the Who's On First repositories and are meant to act a quick and easy index (rather than a full-fledged database) that a person might use to inspect the data. Since there is a lot of tooling developed to support meta files (for example, converting a metafile into a <a href="https://whosonfirst.mapzen.com/bundles/">bundle</a>) it seemed like it would useful to support them as an output format in the API.

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.search&api_key={API_KEY}&q=poutine&page=1&per_page=1&format=meta'
```

#### Example response

```
&lt; HTTP/1.1 200 OK
&lt; Access-Control-Allow-Origin: *
&lt; Content-Type: text/csv
&lt; Date: Tue, 28 Feb 2017 22:25:13 GMT
&lt; Status: 200 OK
&lt; X-api-pagination-cursor: 
&lt; X-api-pagination-next-query: method=whosonfirst.places.search&amp;q=poutine&amp;extras=geom%3Abbox&amp;per_page=1&amp;page=2&amp;format=meta
&lt; X-api-pagination-page: 1
&lt; X-api-pagination-pages: 13
&lt; X-api-pagination-per-page: 1
&lt; X-api-pagination-total: 13
&lt; X-api-format-meta-header: bbox,cessation,country_id,deprecated,file_hash,fullname,geom_hash,geom_latitude,geom_longitude,id,inception,iso,iso_country,lastmodified,lbl_latitude,lbl_longitude,locality_id,name,parent_id,path,placetype,region_id,source,superseded_by,supersedes,wof_country
&lt; Content-Length: 503
&lt; Connection: keep-alive
&lt; 
bbox,cessation,country_id,deprecated,file_hash,fullname,geom_hash,geom_latitude,geom_longitude,id,inception,iso,iso_country,lastmodified,lbl_latitude,lbl_longitude,locality_id,name,parent_id,path,placetype,region_id,source,superseded_by,supersedes,wof_country
"-71.9399642944,46.0665283203,-71.9399642944,46.0665283203",uuuu,0,,,,88060b9c65a5eaae29b427583b1bfa93,46.066528,-71.939964,975139507,uuuu,CA,CA,1472521936,0,0,0,"Poutine Restau-Bar Enr",-1,975/139/507/975139507.geojson,venue,0,simplegeo,,,CA
```

<small>The meta (CVS) header is only written, in the body of the response, for the first page of API responses. The <code>X-api-format-meta-header</code> HTTP header is included with all responses.</small>

#### Notes

Meta (CSV) output is not supported for all API methods.
<a name="pagination"></a>
## Pagination

### A short miserable history (of pagination)

Pagination shouldn't be complicated. But it is. Because databases, after all these years, are still complicated beasts.

Databases have always been about trade-offs. No two databases are the same and so no two sets of trade-offs are the same either. The really short version is that some databases can't tell you exactly how many results there are for a given query. Some databases can tell you how many results there are but can't or won't return results past a certain limit. Other databases can do both but only if you use something called a <code>cursor</code> for pagination rather than the traditional <code>offset</code> and <code>limit</code> model (as in "return the next 5 of 50 results starting from postion 20").

Since there isn't an all-purpose database, the <span class="hey-look">Who&#039;s On First API</span> accounts for multiple different pagination models. We've identified four overlapping models ([plain](#pagination-plain), [cursor](#pagination-cursor), [mixed](#pagination-mixed) and [next-query](#pagination-next-query)) each of which are described in detail below.

If you don't really care and just want to get started [you should skip ahead to the documentation for next-query pagination](#pagination-next-query).

<a name="pagination-plain"></a>
### Plain pagination

Plain pagination assumes that we know how many results a query yields and that we can fetch any set of results at any given offset.

For example, let's say you wanted to use the API to fetch all the places with a variant name containing the word <code>Paris</code> in sets of five. The API will respond with something like this:

```
{
	"results": [ ... ],
	"next_query": "method=whosonfirst.places.search&alt=Paris&per_page=5&page=2",
	<strong>"total": 7</strong>,
	<strong>"page": 1</strong>,
	<strong>"per_page": 5</strong>,
	<strong>"pages": 2</strong>,
	"cursor": null,
	"stat": "ok"
}
```

It's pretty straightforward. There are seven results (<code>total</code>) and this is the first of two pages worth of results (<code>page</code> and <code>pages</code>, respectively). You might already be wondering about the <code>next_query</code> property but [we'll get to that shortly](#pagination-next-query).

<a name="pagination-cursor"></a>
### Cursor-based pagination

Cursor-based pagination is necessary when a database can't or won't tell you how many results there are for a query. This means you will need to pass the same query to the database over and over again for as long as the database returns a <code>cursor</code> which is like a secret hint that <em>only the database understands</em> indicating where the next set of results live.

For example, let's say you wanted to use the API to fetch all of the venues near the [Smithsonian Cooper Hewitt Design Museum](https://whosonfirst.mapzen.com/spelunker/id/420571601/) in sets of ten. The API will respond with something like this:

```
{
	"results": [ ... ],
	"next_query": "method=whosonfirst.places.getNearby&latitude=40.784165&longitude=-73.958110&placetype=venue&per_page=10&cursor={CURSOR}",
	"per_page": 10,
	<strong>"cursor": {CURSOR}</strong>,
	"stat": "ok"
}
```

In order to fetch the next set of results you would include a <code>cursor={CURSOR}</code> parameter in your request, rather than a <code>page={PAGE_NUMBER}</code> parameter like you would with plain pagination. Some databases yield time-sensitive cursors that expire after a number of seconds or minutes so the easiest way to think about cursors is that they are <em>all</em> time sensitive.

_Databases, amirite?_

<a name="pagination-mixed"></a>
### Mixed pagination

This is where it gets fun. Sometimes an API method might use <em>both</em> plain and cursor-based pagination. That can happen when an underlying database is able to calculate the total number of results but only be able to fetch a fraction of them using plain pagination after which it needs to switch to cursor-based pagination. Which doesn't really make any sense when you think about it because cursors are magic database pixie-dust so there's no way to determine or calculate a corresponding cursor for a traditional page number. So in the end the API itself needs to perform an initial query just to see how many results there are and then adjust whether it is going to use plain or cursor-based pagination on the fly.

For example, let's say you wanted to use the API to fetch all the <code>microhoods</code> in sets of five. The API will respond with something like this:

```
{
	"results": [ ... ],
	"next_query": "method=whosonfirst.places.search&placetype=microhood&page=2&per_page=5",
	<strong>"total": 186</strong>,
	<strong>"page": 1</strong>,
	"per_page": 5,
	<strong>"pages": 38</strong>,
	<strong>"cursor": null</strong>,
	"stat": "ok"
}
```

But if you then asked the API to fetch all of the <code>neighbourhoods</code>, again in sets of five, the API will respond with something like this:

```
{
	"results": [ ... ],
	"next_query": "method=whosonfirst.places.search&placetype=neighbourhood&per_page=5&cursor={CURSOR}",
	<strong>"total": 81065</strong>,
	<strong>"page": null</strong>,
	<strong>"pages": 16213</strong>,
	"per_page": 5,
	<strong>"cursor": "{CURSOR}"</strong>,
	"stat": "ok"
}
```

In both examples we know how many results there will be. In the first example we are able to use plain pagination so we know that this is page one of thirty-eight and thus the value of the <code>cursor</code> property is null. In the second example the API has returned a cursor so even though we know the total number of results and can calculate the number of "pages" we set the value of the <code>page</code> property to be null since the requirement on cursor-based pagination makes it moot.

If you look carefully at the value of the <code>next_query</code> property in both examples you can probably figure out where this is going, next.

<a name="pagination-next-query"></a>
### Next-query-based pagination

Next-query based pagination is an attempt to hide most of the implentation details from API consumers and provide a simple "here-do-this-next" style pagination interface, instead.

For example, let's say you wanted to use the API to fetch all the localities (there are over 200, 000 of them) in sets of five. That will require more than 41, 000 API requests but that's your business. The API will respond with a <code>next_query</code> parameter, something like this:

```
{
	"results": [ ... ],
	<strong>"next_query": "method=whosonfirst.places.search&placetype=locality&per_page=5&cursor={CURSOR}"</strong>,
	"total": 208214,
	"page": null,
	"pages": 41643,
	"per_page": 5,
	"cursor": "{CURSOR}",
	"stat": "ok"
}
```

There are a few things to note about the <code>next_query</code> property:

* It contains a URL-encoded query string with the parameters to pass to the API retrieve the <em>next</em> set of results for your query.
* When it is empty (or <code>null</code>) that means there are no more results.
* It <em>does not</em> contain any user-specific access tokens or API keys &#8212; you will need to add those yourself.
* It <em>does not</em> contain any host or endpoint specific information  &#8212; you will need to add that yourself.
* You may want or need to decode the query string in order to append additional parameters (like authentication) and to handle how those parameters are sent along to the API. For example, whether the method is invoked using HTTP's <code>GET</code> or <code>POST</code> method or whether parameters should be <code>multipart/mime</code> encoded or not. And so on.

This type of pagination is not ideal but strives to be a reasonable middle-ground that is not too onerous to implement and easy to use.

<a name="pagination-headers"></a>
### Pagination and HTTP headers

Pagination properties are also returned as HTTP response headers. This is useful for any output format and necessary for output formats like plain old [CSV](#formats-csv) or Who's On First's [meta](#formats-meta) format. All of the pagination properties you've come to know and love in the examples above are also returned as HTTP response header prefixed by <code>X-api-pagination-</code>.

For example: 

```
$> curl -s -v -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.search&api_key=API_KEY&q=poutine&extras=geom:bbox&page=1&format=csv&per_page=1'

&lt; HTTP/1.1 200 OK
&lt; Access-Control-Allow-Origin: *
&lt; Content-Type: text/csv
&lt; Date: Tue, 28 Feb 2017 21:13:37 GMT
&lt; Status: 200 OK
<strong>&lt; X-api-pagination-cursor: 
&lt; X-api-pagination-next-query: method=whosonfirst.places.search&amp;q=poutine&amp;extras=geom%3Abbox&amp;per_page=1&amp;page=2&amp;format=csv
&lt; X-api-pagination-page: 1
&lt; X-api-pagination-pages: 13
&lt; X-api-pagination-per-page: 1
&lt; X-api-pagination-total: 13</strong>
&lt; X-whosonfirst-csv-header: geom_bbox,wof_country,wof_id,wof_name,wof_parent_id,wof_placetype,wof_repo
&lt; Content-Length: 208
&lt; Connection: keep-alive
&lt; 
geom_bbox,wof_country,wof_id,wof_name,wof_parent_id,wof_placetype,wof_repo
"-71.9399642944,46.0665283203,-71.9399642944,46.0665283203",CA,975139507,"Poutine Restau-Bar Enr",-1,venue,whosonfirst-data-venue-ca
```
<a name="error-codes"></a>
## Error codes

In addition to any already <a href="https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml">assigned HTTP status codes</a> <span class="hey-look">Who&#039;s On First API</span> defines the following additional status codes for representing errors or a failure scenario, across all API methods:

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

Individual API methods may define their own status codes within the <code>432-449</code> and <code>513-599</code> range on a per-method basis. Status codes in this range <em>may</em> be used with different meanings by different API methods and it is left to API consumers to account for those differences.

The status codes defined above (<code>450</code>, <code>452-499</code>, <code>512</code>) are unique and common to all API methods.