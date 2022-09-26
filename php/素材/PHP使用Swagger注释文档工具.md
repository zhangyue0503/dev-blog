



## 排序问题

Tag名前面带个数字用于排序，比如

```php
/**
 * @OA\Tag (
 *     name="1.首页",
 *     description="首页"
 * )
 */
```



```javascript
// swagger-initializer.js
tagsSorter: function(a, b){
  // swagger-ui 排序问题
  const reg = /^\d*/g
  let numa = a.match(reg)
  let numb = b.match(reg)
  if (numa[0] == '') numa[0] = 9999
  if (numb[0] == '') numb[0] = 9999
  return numa[0]-numb[0]
},
```

