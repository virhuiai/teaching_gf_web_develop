<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\NewsModel;

class News extends ResourceController
{
	use ResponseTrait;

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
	// POST http://127.0.0.1/index.php/news/
	// Content-Type: application/json

	// {
	//   "title": "31省新增确诊80例, 本土65例",
	//   "slug": "80_newly_diagnosed_cases_in_31_provinces_and_65_in_local_areas",
	//   "body": "国家卫健委消息，1月23日0—24时，31个省（自治区、直辖市）和新疆生产建设兵团报告新增确诊病例80例，其中境外输入病例15例（广东5例，上海3例，山西2例，天津1例，辽宁1例，江苏1例，陕西1例，甘肃1例），本土病例65例（黑龙江29例，河北19例，吉林12例，上海3例，北京2例）；无新增死亡病例；新增疑似病例1例，为境外输入病例（在上海）。"
	// }

	/**®
	 * 增
	 * create
	 * Send POST request with body as parameters
	 * 
	 */
	// public function create()
	// {
	// 	$model = new NewsModel();
	// 	$data = [
	// 		'title' => $this->request->getVar('title'),
	// 		// slug that will become an article or page URL, 嵌条
	// 		'slug'  => $this->request->getVar('slug'),
	// 		'body'  => $this->request->getVar('body')
	// 	];
	// 	$model->insert($data);
	// 	$response = [
	// 		'status'   => 201,
	// 		'error'    => null,
	// 		'messages' => [
	// 			'success' => 'News created successfully'
	// 		]
	// 	];
	// 	return $this->respondCreated($response);
	// }
	// POST http://127.0.0.1/index.php/news/
	// Content-Type: application/x-www-form-urlencoded
	
	// title=title_test&slug=slug_test&body=body_test
	
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
	// GET http://127.0.0.1/index.php/news/1
	// {
	// 	"status": 501,
	// 	"error": 501,
	// 	"messages": {
	// 	  "error": "\"show\" action not implemented."
	// 	}
	//   }	

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
	// PATCH http://127.0.0.1/index.php/news/2  或 PUT http://127.0.0.1/index.php/news/2
	// Content-Type: application/json

	// {
	// "title": "31省新增确诊80例, 本土65例",
	// "slug": "80_newly_diagnosed_cases_in_31_provinces_and_65_in_local_areas",
	// "body": "国家卫健委消息，1月23日0—24时，31个省（自治区、直辖市）和新疆生产建设兵团报告新增确诊病例80例，其中境外输入病例15例（广东5例，上海3例，山西2例，天津1例，辽宁1例，江苏1例，陕西1例，甘肃1例），本土病例65例（黑龙江29例，河北19例，吉林12例，上海3例，北京2例）；无新增死亡病例；新增疑似病例1例，为境外输入病例（在上海）。"
	// }


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
	// DELETE http://127.0.0.1/index.php/news/2
}
