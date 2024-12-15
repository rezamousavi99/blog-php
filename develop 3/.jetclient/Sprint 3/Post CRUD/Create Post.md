```toml
name = 'Create Post'
description = '/api/create-post'
method = 'POST'
url = '{{baseUrl}}/api/create-post'
sortWeight = 1000000
id = '96d52a95-1a39-4fe6-b683-9e59ef0d8f36'

[[headers]]
key = 'Accept'
value = 'application/json'

[auth.bearer]
token = '1|75G3fJvvDL5k8rD36HpWXTye7UGUsKx4updV5b520675964e'

[body]
type = 'JSON'
raw = '''
{
    "title": "last week post13",
    "content": "about hike",
    "excerpt": "sdlsdf",
    "tags": ["snake", "ratt"]
}'''
```

### Example

```toml
name = 'Validation 422'
id = '87c41069-f2cb-43e2-8392-545a97aac0d6'

[[headers]]
key = 'Accept'
value = 'application/json'

[body]
type = 'JSON'
raw = '''
{
    "title": "",
    "content": "about hike",
    "excerpt": "sdlsdf",
    "tags": ["New"]
}'''
```

### Example

```toml
name = 'Success 200'
id = 'd597e489-4708-4744-92cf-8930cc7355a5'

[[headers]]
key = 'Accept'
value = 'application/json'

[body]
type = 'JSON'
raw = '''
{
    "title": "test",
    "content": "about hike",
    "excerpt": "sdlsdf",
    "tags": ["New", "Featured"]
}'''
```
