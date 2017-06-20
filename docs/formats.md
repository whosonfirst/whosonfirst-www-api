<a name="formats"></a>
## Response formats

The default response format is [JSON](formats.md#json).

<a name="chicken"></a>
### CHICKEN

🐔 🐔 🐔

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com/?method=whosonfirst.places.getInfoMulti&api_key=your-mapzen-api-key&ids=101712565,101712563&format=chicken'
```

#### Example response

```
< HTTP/1.1 200 OK
< Access-Control-Allow-Origin: *
< Content-Type: text/chicken
< Date: Tue, 25 Apr 2017 14:08:08 GMT
{
    "🐔": [
        {
            "🐔:🐔": 101712565,
            "🐔:🐔_🐔": "404525063",
            "🐔:🐔": "🐔 🐔",
            "🐔:🐔": "🐔",
            "🐔:🐔": "🐔",
            "🐔:🐔": "🐔-🐔"
        },
        {
            "🐔:🐔": 101712563,
            "🐔:🐔_🐔": "404523697",
            "🐔:🐔": "🐔",
            "🐔:🐔": "🐔",
            "🐔:🐔": "🐔",
            "🐔:🐔": "🐔-🐔"
        }
    ]
}
```

#### Notes

🐔 (chicken) output is supported for all API methods.

<a name="csv"></a>
### CSV

CSV (Comma Separated Value)

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.search&api_key=your-mapzen-api-key&q=poutine&page=1&per_page=1&format=csv'
```

#### Example response

```
< HTTP/1.1 200 OK
< Access-Control-Allow-Origin: *
< Content-Type: text/csv
< Date: Tue, 28 Feb 2017 21:13:37 GMT
< Status: 200 OK
< X-api-pagination-cursor: 
< X-api-pagination-next-query: method=whosonfirst.places.search&amp;q=poutine&amp;extras=geom%3Abbox&amp;per_page=1&amp;page=2&amp;format=csv
< X-api-pagination-page: 1
< X-api-pagination-pages: 13
< X-api-pagination-per-page: 1
< X-api-pagination-total: 13
< X-api-format-csv-header: geom_bbox,wof_country,wof_id,wof_name,wof_parent_id,wof_placetype,wof_repo
< Content-Length: 208
< Connection: keep-alive

geom_bbox,wof_country,wof_id,wof_name,wof_parent_id,wof_placetype,wof_repo
"-71.9399642944,46.0665283203,-71.9399642944,46.0665283203",CA,975139507,"Poutine Restau-Bar Enr",-1,venue,whosonfirst-data-venue-ca
```

<small>The CVS header is only written, in the body of the response, for the first page of API responses. The `X-api-format-csv-header` HTTP header is included with all responses.</small>

#### Notes

CSV output is not supported for all API methods.
<a name="geojson"></a>
### GEOJSON

GeoJSON is a data-interchange format based on JavaScript. For more details, consult <a href="http://geojson.org/">http://geojson.org/</a>.

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.getInfoMulti&api_key=your-mapzen-api-key&&ids=101712565,101712563&format=geojson'
```

#### Example response

```
< HTTP/1.1 200 OK
< Access-Control-Allow-Origin: *
< Content-Type: text/json
< Date: Tue, 25 Apr 2017 14:08:08 GMT
{
    "bbox": [
        -81.680223,
        41.479264,
        -81.563564,
        41.511215
    ],
    "features": [
        {
            "geometry": {
                "coordinates": [
                    -81.563564,
                    41.511215
                ],
                "type": "Point"
            },
            "properties": {
                "geom:latitude": 41.511215,
                "geom:longitude": -81.563564,
                "lbl:latitude": 41.510978,
                "lbl:longitude": -81.564146,
                "wof:country": "US",
                "wof:id": 101712565,
                "wof:name": "Cleveland Heights",
                "wof:parent_id": "404525063",
                "wof:placetype": "locality",
                "wof:repo": "whosonfirst-data"
            },
            "type": "Feature"
        },
        {
            "geometry": {
                "coordinates": [
                    -81.680223,
                    41.479264
                ],
                "type": "Point"
            },
            "properties": {
                "geom:latitude": 41.479264,
                "geom:longitude": -81.680223,
                "lbl:latitude": 41.496551,
                "lbl:longitude": -81.65133,
                "wof:country": "US",
                "wof:id": 101712563,
                "wof:name": "Cleveland",
                "wof:parent_id": "404523697",
                "wof:placetype": "locality",
                "wof:repo": "whosonfirst-data"
            },
            "type": "Feature"
        }
    ],
    "type": "FeatureCollection"
}
```

#### Notes

As of this writing all GeoJSON formatted responses are returned as a `FeatureCollection` whose member geometry type is a `Point` representing either a label centroid, when available, or the geographic centroid of the feature.

GeoJSON output is not supported for all API methods.
<a name="json"></a>
### JSON

JSON (JavaScript Object Notation) is a data-interchange format based on JavaScript. For more details, consult <a href="http://json.org/">http://json.org/</a>.

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.search&api_key=your-mapzen-api-key&q=poutine&page=1&per_page=1&format=json'
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

#### Notes

JSON output is supported for all API methods.

<a name="meta"></a>
### Meta file

As in a Who's On First "meta" file. A meta file is really just a CSV file with a pre-defined set of column headers. Meta files are included with all of the Who's On First repositories and are meant to act a quick and easy index (rather than a full-fledged database) that a person might use to inspect the data. Since there is a lot of tooling developed to support meta files (for example, converting a metafile into a <a href="https://whosonfirst.mapzen.com/bundles/">bundle</a>) it seemed like it would useful to support them as an output format in the API.

#### Example request

```
curl -X GET 'https://whosonfirst-api.mapzen.com?method=whosonfirst.places.search&api_key=your-mapzen-api-key&q=poutine&page=1&per_page=1&format=meta'
```

#### Example response

```
< HTTP/1.1 200 OK
< Access-Control-Allow-Origin: *
< Content-Type: text/csv
< Date: Tue, 28 Feb 2017 22:25:13 GMT
< Status: 200 OK
< X-api-pagination-cursor: 
< X-api-pagination-next-query: method=whosonfirst.places.search&amp;q=poutine&amp;extras=geom%3Abbox&amp;per_page=1&amp;page=2&amp;format=meta
< X-api-pagination-page: 1
< X-api-pagination-pages: 13
< X-api-pagination-per-page: 1
< X-api-pagination-total: 13
< X-api-format-meta-header: bbox,cessation,country_id,deprecated,file_hash,fullname,geom_hash,geom_latitude,geom_longitude,id,inception,iso,iso_country,lastmodified,lbl_latitude,lbl_longitude,locality_id,name,parent_id,path,placetype,region_id,source,superseded_by,supersedes,wof_country
< Content-Length: 503
< Connection: keep-alive

bbox,cessation,country_id,deprecated,file_hash,fullname,geom_hash,geom_latitude,geom_longitude,id,inception,iso,iso_country,lastmodified,lbl_latitude,lbl_longitude,locality_id,name,parent_id,path,placetype,region_id,source,superseded_by,supersedes,wof_country
"-71.9399642944,46.0665283203,-71.9399642944,46.0665283203",uuuu,0,,,,88060b9c65a5eaae29b427583b1bfa93,46.066528,-71.939964,975139507,uuuu,CA,CA,1472521936,0,0,0,"Poutine Restau-Bar Enr",-1,975/139/507/975139507.geojson,venue,0,simplegeo,,,CA
```

<small>The meta (CVS) header is only written, in the body of the response, for the first page of API responses. The `X-api-format-meta-header` HTTP header is included with all responses.</small>

#### Notes

Meta (CSV) output is not supported for all API methods.
