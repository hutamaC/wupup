<?php
return  [
			'common' =>[

							[

								'name'=>'自定义导航栏',
								'tag'=>'admin.nav.index',
								'url'=>'/admin/nav',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

							[

								'name'=>'整站图片管理',
								'tag'=>'admin.image.index',
								'url'=>'/admin/image',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],
						    
						    [

								'name'=>'友情链接管理',
								'tag'=>'admin.link.index',
								'url'=>'/admin/link',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],
			],

			'index' =>[

								[

								'name'=>'系统信息',
								'tag'=>'admin.system.index',
								'url'=>'/admin/index',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],
			],
			'city' =>[

								[

								'name'=>'城市分站列表',
								'tag'=>'admin.site.index',
								'url'=>'/admin/site',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],
			],
			'goods' =>[

							[

								'name'=>'商品列表',
								'tag'=>'admin.goods.index',
								'url'=>'/admin/goods',
								'icon'=>'<i class="icon-present"></i>'
						    ],

						    [

								'name'=>'商品分类',
								'tag'=>'admin.category.index',
								'url'=>'/admin/category',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    [

								'name'=>'商品品牌',
								'tag'=>'admin.brand.index',
								'url'=>'/admin/brand',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

							[

								'name'=>'商品类型管理',
								'tag'=>'admin.type.index',
								'url'=>'/admin/type',
								
						    ],

						    [

								'name'=>'属性管理',
								'tag'=>'admin.attribute.index',
								'url'=>'/admin/attribute',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    [

								'name'=>'商品规格',
								'tag'=>'admin.field.index',
								'url'=>'/admin/field',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    [

								'name'=>'颜色属性管理',
								'tag'=>'admin.color.index',
								'url'=>'/admin/color',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],


						    [

								'name'=>'属性链货品管理',
								'tag'=>'admin.product.index',
								'url'=>'/admin/product',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    
						    [

								'name'=>'命令行批量添加商品',
								'tag'=>'admin.command.index',
								'url'=>'/admin/command',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    [

								'name'=>'商品图片批量处理',
								'tag'=>'admin.goods.image',
								'url'=>'/admin/goods/image',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    [

								'name'=>'标签管理',
								'tag'=>'admin.tag.index',
								'url'=>'/admin/tag',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],

						    [

								'name'=>'商品回收站',
								'tag'=>'admin.cycle.index',
								'url'=>'/admin/cycle',
								'icon'=>'<i class="fa fa-home"><i>'
						    ],
			],

			'promotion'=>[
							[
								'name'=>'礼品卡列表',
								'tag'=>'admin.card.index',
								'url'=>'/admin/card',
								'icon'=>'',
							],
			],


			'order'=>[
								[
									'name'=>'订单列表',
									'tag'=>'admin.order.index',
									'url'=> '/admin/order',
									'icon'=>'',

								],
								[
									'name'=>'添加订单',
									'tag'=>'admin.order.create',
									'url'=>'/admin/order/create',
								],
								[
									'name'=>'订单日志',
									'tag'=>'admin.order.log',
									'url'=> '/admin/order/log',
								],

								[
									'name'=>'发货单管理',
									'tag'=>'admin.express.index',
									'url'=> '/admin/express',
								],

								[
									'name'=>'退货管理',
									'tag'=>'admin.return.index',
									'url'=> '/admin/return',
								],
								[
									'name'=>'订单打印',
									'tag'=>'admin.order.print',
									'url'=> '/admin/order/print',
								],
			],

			'user' =>[

										[

												'name'=>'用户列表',
												'tag'=>'admin.user.index',
												'url'=>'/admin/user',
												'icon'=>'<i class="icon-present"></i>'
										],

									  [

											'name'=>'会员等级',
											'tag'=>'admin.user_rank.index',
											'url'=>'/admin/user_rank',
											'icon'=>'<i class="fa fa-home"><i>'
									  ],

									  [

											'name'=>'充值和提现',
											'tag'=>'admin.account.index',
											'url'=>'/admin/account',
											'icon'=>'<i class="fa fa-home"><i>'
									  ],
									  [

											'name'=>'会员留言',
											'tag'=>'admin.message.index',
											'url'=>'/admin/message',
											'icon'=>'<i class="fa fa-home"><i>'
									  ],

									  [

											'name'=>'短消息管理',
											'tag'=>'admin.sms.index',
											'url'=>'/admin/sms ',
											'icon'=>'<i class="fa fa-home"><i>'
									  ],

									  [

											'name'=>'演示账号管理',
											'tag'=>'admin.demo.index',
											'url'=> '/admin/demo',
											'icon'=>'<i class="fa fa-home"><i>'
									  ],
			],


			'dev'	=>[


								[
									'name'=>'系统数据字典',
									'tag'=>'databases',
									'url'=>'/admin/databases',
									'icon'=>'<i class="fa fa-cogs"></i>'

								],

								[
									'name'=>'centos安装',
									'tag'=>'redis',
									'url'=> '/redis',
									'icon'=>'<i class="fa fa-cogs"></i>'

								],

								[
									'name'=>'滚动组件',
									'tag'=>'carousel',
									'url'=> '/carousel',
									'icon'=>'<i class="fa fa-cogs"></i>',
								],

								[
									'name'=>'前端表单样式',
									'tag'=>'mwui',
									'url'=> '/mwui',
									'icon'=>'<i class="fa fa-cogs"></i>',
								],


								[
									'name'=>'tabledata组件',
									'tag'=>'tabledata',
									'url'=> '/tabledata',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'分页组件',
									'tag'=>'page',
									'url'=> '/page',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'grid组件',
									'tag'=>'grid',
									'url'=> '/grid',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
			],

			'article'	 =>[
								[
									'name'=>'文章列表',
									'tag'=>'admin.article.index',
									'url'=> '/admin/article',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'文章分类',
									'tag'=>'admin.article_cat.index',
									'url'=> '/admin/article_cat',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
			],

			'supplier'	 =>[
								[
									'name'=>'供货商列表',
									'tag'=>'admin.supplier.index',
									'url'=> '/admin/supplier',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								
			],

			'privi'	 =>[
								[
									'name'=>'管理员列表',
									'tag'=>'admin.administrator.index',
									'url'=> '/admin/administrator',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'系统所有权限清单',
									'tag'=>'admin.privi.index',
									'url'=> '/admin/privi',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
								[
									'name'=>'角色管理',
									'tag'=>'admin.role.index',
									'url'=> '/admin/role',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'日志管理',
									'tag'=>'admin.log.index',
									'url'=> '/admin/log',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],


								[
									'name'=>'退出登录',
									'tag'=>'admin.administrator.logout',
									'url'=> '/admin/administrator/logout',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

			],

			'template' =>[
				                [
									'name'=>'模板设置',
									'tag'=>'admin.template.index',
									'url'=> '/admin/template',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
								[
									'name'=>'模板颜色选择器',
									'tag'=>'admin.style.index',
									'url'=> '/admin/style',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
						],

	        'config' =>[
				                [
									'name'=>'商城系统设置',
									'tag'=>'admin.config.index',
									'url'=> '/admin/config',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'首页幻灯片设置',
									'tag'=>'admin.slider.index',
									'url'=> '/admin/slider',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'分类广告管理',
									'tag'=>'admin.catad.index',
									'url'=> '/admin/catad',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'支付方式',
									'tag'=>'admin.payment.index',
									'url'=> '/admin/payment',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'配送方式',
									'tag'=>'admin.shipping.index',
									'url'=> '/admin/shipping',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],

								[
									'name'=>'地区运费设置',
									'tag'=>'admin.region_shipping.index',
									'url'=> '/admin/region_shipping',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
								

			],

			'mobile' =>[
				                [
									'name'=>'wap版本基本设置',
									'tag'=>'admin.wap.index',
									'url'=> '/admin/wap',
									'icon'=>'<i class="fa fa-cogs"></i>'
								],
			],
];