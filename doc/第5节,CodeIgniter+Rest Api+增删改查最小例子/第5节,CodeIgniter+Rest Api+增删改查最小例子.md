# 创建支持中文的表news



```sql
CREATE TABLE news (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(128) character set utf8mb4 collate utf8mb4_unicode_ci NOT NULL ,
  slug varchar(128) character set utf8mb4 collate utf8mb4_unicode_ci NOT NULL,
  body text character set utf8mb4 collate utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id),
  KEY slug (slug)
);
```





# 创建 REST API Route

为了使用Rest方式的Api，我们在CI中定义路由。



打开 `app/Config/Routes.php` 文件，然后查找以下代码。



```php
$Route->get('/', 'home::index');
```



接下来，添加下面的代码行：



```php
$routes->resource('news');
```



![image-20210124152003111](assets/image-20210124152003111.png)



增删改查4个情况的路由，不用再具体定义，使用这种方式就可以自动定义好默认的方式。具体的我们下面正删改查代码的时候再说到。



# 创建Model



在 `/app/Models/` 目录中创建一个模型文件`NewsModel.php`。 将以下代码放入文件中以定义模型：



```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'body'];
}
```





![image-20210124151121800](assets/image-20210124151121800.png)



分三个部分，`$table`是表名，`$primaryKey`是表的主键名，还有一个`$allowedFields`表示更新的时候允许更新的字段。



# 创建REST Controller

在 `/app/Controllers/` 文件夹中创建一个控制器 `News.php`。 在此文件中，后续我们将创建增、删、改查的功能。



```php
<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\NewsModel;

class News extends ResourceController
{
	use ResponseTrait;

}	
```





![image-20210124151523883](assets/image-20210124151523883.png)



增加其实有两种方式的请求，这儿都介绍一下。



# PhsStorm里的接口的测试



![image-20210124152701847](assets/image-20210124152701847.png)



这里介绍下PhpStrom的接口测试工具，点击`Tool`点`HTTP Client`在点这边`Open HTTP Requests Collection`。



会出现一些例子。



![image-20210124153045581](assets/image-20210124153045581.png)



我们修改一下相应的部分的参数，再点击左边绿色的小三角就可以发起请求了。



也可以用图形化的操作



![image-20210124153444017](assets/image-20210124153444017.png)



接着出现：



![image-20210124153545223](assets/image-20210124153545223.png)



填写完后同样点绿色小点就可以发出请求了。我习惯第一种方式，也是推荐的方式。



# 增,Send POST request with json body



例子中是这样的：



```
### Send POST request with json body
POST https://httpbin.org/post
Content-Type: application/json

{
  "id": 999,
  "value": "content"
}
```



我们新闻的是news，所以我们的请求会是：



```
POST http://127.0.0.1/index.php/news/
	Content-Type: application/json

	{
	  "title": "31省新增确诊80例, 本土65例",
	  "slug": "80_newly_diagnosed_cases_in_31_provinces_and_65_in_local_areas",
	  "body": "国家卫健委消息，1月23日0—24时，31个省（自治区、直辖市）和新疆生产建设兵团报告新增确诊病例80例，其中境外输入病例15例（广东5例，上海3例，山西2例，天津1例，辽宁1例，江苏1例，陕西1例，甘肃1例），本土病例65例（黑龙江29例，河北19例，吉林12例，上海3例，北京2例）；无新增死亡病例；新增疑似病例1例，为境外输入病例（在上海）。"
	}
```



我们现在点击一下绿色的小三角，可以看到个报错：



![image-20210124154517466](assets/image-20210124154517466.png)



这告诉我们，控制器中`create`这个方法并没有创建。路由那边的配置`$routes->resource('news');`会自动生成几条增删改查相关的配置，我们直接根据请求来看看缺哪个方法补上就好了。



**在控制器News中添加方法**



```php
	/**®
	 * 增
	 * create
	 * Send POST request with json body
	 * 
	 */
	public function create()
	{
		$model = new NewsModel();
		// var_dump($this->request->post('title'));
		$json = $this->request->getJSON(true);
		// 这里可以做个对数据的验证，是否合法的验证
		$data = [
			'title' => $json['title'],
			// slug that will become an article or page URL, 嵌条
			'slug'  => $json['slug'],
			'body'  => $json['body']
		];

		$model->insert($data);
		$response = [
			'status'   => 201,
			'error'    => null,
			'messages' => [
				'success' => 'created successfully'
			]
		];
		return $this->respondCreated($response);
	}
```



![image-20210124154721254](assets/image-20210124154721254.png)



现在再试下请求：



![image-20210124155023039](assets/image-20210124155023039.png)



提示返回创建成功了，自己可以直接去数据库查看一下，下面介绍另一种方式，Send POST request with body as parameters。



# 增，Send POST request with body as parameters



这种方式的请求，在PhpStorm里的例子是这样子的。



```
POST http://localhost:80/api/item
Content-Type: application/x-www-form-urlencoded

id=99&content=new-element
```



根据我们的情况，我们改为以下方式：



```
POST http://127.0.0.1/index.php/news/
Content-Type: application/x-www-form-urlencoded

title=title_test&slug=slug_test&body=body_test
```



**在控制器News中添加方法**



请求方式不一样了，这边取到请求数据的方式也是不一样的，我们把之前的代码注释后再写一个：



```php
	/**®
	 * 增
	 * create
	 * Send POST request with body as parameters
	 * 
	 */
	public function create()
	{
		$model = new NewsModel();
		$data = [
			'title' => $this->request->getVar('title'),
			// slug that will become an article or page URL, 嵌条
			'slug'  => $this->request->getVar('slug'),
			'body'  => $this->request->getVar('body')
		];
		$model->insert($data);
		$response = [
			'status'   => 201,
			'error'    => null,
			'messages' => [
				'success' => 'News created successfully'
			]
		];
		return $this->respondCreated($response);
	}
```



![image-20210124155448404](assets/image-20210124155448404.png)



尝试下上面的请求，有如下返回，说明成功了。



![image-20210124155548229](assets/image-20210124155548229.png)



虽然说增删改查我一直念得比较顺口，但我们添加的数据后要看下添加成功没有，那我们先介绍一下查吧。



# 查，所有



查询所有的请求是：



```
GET http://localhost:80/index.php/news
Accept: application/json

<> 2021-01-24T035837.200.json

###
```



查询之前我们控制其中，也需要准备一下方法index。



```php
	/**
	 * 查，所有
	 * all news
	 * news作"消息","新闻"时必须用"复数形式",但不可加用数词,但可使用 a piece of news(一条消息),two articles of news(二条消息)
	 * 
	 */
	public function index()
	{
		$model = new NewsModel();
		$data = $model->orderBy('id', 'DESC')->findAll();
		return $this->respond($data);
	}
```



![image-20210124160021968](assets/image-20210124160021968.png)



现在我们调用一下查询所有的接口，可以看到，已经可以看到前面两种方式插入的数据了：



![image-20210124160107624](assets/image-20210124160107624.png)



# 查，单条

接下来内容介绍就简化一些，在控制器中添加方法show。



```php
	/**
	 * 查，单个
	 * single
	 */
	public function show($id = null)
	{
		$model = new NewsModel();
		$data = $model->where('id', $id)->first();
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No found');
		}
	}
```



![image-20210124160411854](assets/image-20210124160411854.png)



请求：



```
GET http://localhost:80/index.php/news/1
Accept: application/json
```



![image-20210124160457965](assets/image-20210124160457965.png)



下面我们介绍一下修改内容。



# 改



在控制器中添加方法update。



```php
	/**
	 * 改
	 * update
	 */
	public function update($id = null)
	{
		$model = new NewsModel();
		$json = $this->request->getJSON(true);
		// 这里可以做个对数据的验证，是否合法的验证
		$data = [
			'title' => $json['title'],
			// slug that will become an article or page URL, 嵌条
			'slug'  => $json['slug'],
			'body'  => $json['body']
		];
		$model->update($id, $data);
		$response = [
			'status'   => 200,
			'error'    => null,
			'messages' => [
				'success' => 'updated successfully'
			]
		];
		return $this->respond($response);
	}
```



![image-20210124160618863](assets/image-20210124160618863.png)



现在请求下修改：



```
PATCH http://127.0.0.1/index.php/news/2
Content-Type: application/json

{
  "title": "title 2 update_1",
  "slug": "title_2_update_1",
  "body": "title 2 update_1 , PATCH"
}
```



![image-20210124160924766](assets/image-20210124160924766.png)



可以查看到修改成功：



![image-20210124161003553](assets/image-20210124161003553.png)



也可以使用PUT的方法：



```
PUT http://127.0.0.1/index.php/news/1
Content-Type: application/json

{
  "title": "title 1 update_2",
  "slug": "title_1_update_2",
  "body": "title 1 update_2 , PUT"
}
```



![image-20210124161055314](assets/image-20210124161055314.png)



查看下结果：



![image-20210124161129602](assets/image-20210124161129602.png)



# 删



最后就是介绍一下删除了。在控制器中添加方法delete。



```php
	/**
	 * 删
	 * delete
	 */
	public function delete($id = null)
	{
		$model = new NewsModel();
		$data = $model->where('id', $id)->delete($id);
		if ($data) {
			$model->delete($id);
			$response = [
				'status'   => 200,
				'error'    => null,
				'messages' => [
					'success' => 'successfully deleted'
				]
			];
			return $this->respondDeleted($response);
		} else {
			return $this->failNotFound('No found');
		}
	}
```



请求：



```
DELETE http://127.0.0.1/index.php/news/2
```



![image-20210124161316109](assets/image-20210124161316109.png)



再看下所有的数据会发现已经删除成功了：



![image-20210124161359847](assets/image-20210124161359847.png)



好了，CI的rest方式的增删改查写法就介绍到到，后面再介绍如何和前端配合起来。