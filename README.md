# 序列号服务器库

### 安装要求

* easySwoole (=1.x)
* php (>=5.6)
* mysql (>=5.5)
* swoole (>=1.9.11)
* php-yaml
* php-mysqli

### 安装方法
命令行快速安装：`bash <(curl https://www.easyswoole.com/installer.sh)`

或是：`curl https://www.easyswoole.com/installer.php | php`

# Mysql表结构
##### 表名：giftbag（礼包）
```sql
CREATE TABLE IF NOT EXISTS `xdapp_cdkey`.`giftbag` (
  `id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号',
  `code` VARCHAR(6) NOT NULL COMMENT '礼包码',
  `name` VARCHAR(150) NULL COMMENT '名称',
  `cid` INT(10) NULL DEFAULT 0 COMMENT '渠道',
  `sids` TEXT NULL COMMENT '服',
  `type` INT(4) NULL DEFAULT 0 COMMENT '类型(容量类型)',
  `items` TEXT NULL COMMENT '领取物品',
  `settings` TINYINT(4) NULL DEFAULT 0 COMMENT '设置信息',
  `all_count` INT(10) NULL DEFAULT 0 COMMENT '礼包数量',
  `produce_count` INT(10) NULL DEFAULT 0 COMMENT '生成数量',
  `received_count` INT(10) NULL DEFAULT 0 COMMENT '领取数量',
  `used_count` INT(10) NULL DEFAULT 0 COMMENT '使用数量',
  `received_max` TINYINT(4) NULL DEFAULT 1 COMMENT '最大领取次数',
  `used_max` TINYINT(4) NULL DEFAULT 1 COMMENT '最大使用次数',
  `curr_banch` INT(6) NULL DEFAULT 0 COMMENT '当前批次',
  `start_time` INT(10) NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` INT(10) NULL DEFAULT 0 COMMENT '结束时间',
  `status` TINYINT(2) NULL DEFAULT 0 COMMENT '状态(0:关闭；1：开启；2：暂停)',
  `create_time` INT(10) NULL DEFAULT 0 COMMENT '创建时间',
  `create_admin_id` INT(10) NULL DEFAULT 0 COMMENT '创建人',
  `update_time` INT(10) NULL COMMENT '更新时间',
  `update_amdin_id` INT(10) NULL COMMENT '更新人',
  `desc` TEXT NULL COMMENT '描述',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code` (`code` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COMMENT = '礼包';
```
##### 表名：cdkey_{giftbag_id}（礼券）
```sql
CREATE TABLE IF NOT EXISTS `xdapp_cdkey`.`cdkey_{giftbag_id}` (
  `code` VARCHAR(32) NOT NULL COMMENT '兑换码',
  `batch` INT(6) NULL DEFAULT 0 COMMENT '批次',
  `account` VARCHAR(100) NULL COMMENT '账号',
  `receive_pid` BIGINT(20) NULL DEFAULT 0 COMMENT '领取角色',
  `receive_time` INT(10) NULL DEFAULT 0 COMMENT '领取时间',
  `used_pid` BIGINT(20) NULL DEFAULT 0 COMMENT '使用角色',
  `used_time` INT(10) NULL DEFAULT 0 COMMENT '使用时间',
  `create_time` INT(10) NULL DEFAULT 0 COMMENT '创建时间',
  `status` TINYINT(2) NULL DEFAULT 0 COMMENT '状态',
  `mark` VARCHAR(150) NULL COMMENT '标记',
  `ext` TEXT NULL COMMENT '其他',
  PRIMARY KEY (`code`),
  INDEX `receive_pid` (`receive_pid` ASC),
  INDEX `used_pid` (`used_pid` ASC),
  INDEX `banch` (`batch` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COMMENT = '兑换码';
```

### 启动服务
根目录执行 `php server start` start(启动), stop(停止), reload(重载)，update(更新项目Core目录)

# API接口

## 1.通讯协议
http

## 2.公共参数（url参数）
| 参数 | 类型 | 描述 |
| :--- | :--- | :--- |
| time | int | 请求时间 |
| sign | string | 签名 |

## 3.签名算法
格式：md5({time}{token})

举例：`http://127.0.0.1/api/cdkey/use?time=1517539152&sign=3c031ee08db6270190e1fc9646b6aa8e`

## 4.接口列表

### 4.1创建礼包
方式：`POST`

地址：`http://127.0.0.1:9899/api/giftbag/add?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| name | string | 是 | 礼包名 |
| cid | string | 否 | 渠道id |
| sids | string | 否 | 服信息 |
| type | int | 是 | 类型位（8/10/12） |
| produce_count | int | 否 | 生成数量 |
| items | string | 是 | 道具 |
| is_band | int | 否 | 是否绑定角色 |
| received_max | int | 否 | 最多领取次数（默认为1） |
| used_max | int | 否 | 最多使用次数（默认为1） |
| start_time | int | 是 | 开始时间 |
| end_time | int | 否 | 结束时间 |
| create_admin_id | int | 是 | 管理员id |
| receive_produce | int | 否 | 允许领取时生成兑换码 |
| status | int | 否 | 状态(关闭：0, 开启：1, 暂停：2) |
| desc | string | 否 | 描述 |

curl测试命令:`curl -d "name=100cdkey&items={['id':1,'num':10}&type=12&produce_count=100&create_admin_id=1&start_time=1517155200&end_time=1543593600&is_band=1&receive_produce=1&status=1" "http://127.0.0.1:9899/api/giftbag/add?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 4.2礼包列表
方式：`GET`

地址：`http://127.0.0.1:9899/api/giftbag/list?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| name | string | 否 | 礼包名称 |
| status | int | 否 | 状态 |
| offset | int | 否 | 开始 |
| limit | int | 否 | 数量 |

curl测试命令:`curl "http://127.0.0.1:9899/api/giftbag/list?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 4.3修改礼包
方式：`POST`

地址：`http://127.0.0.1:9899/api/giftbag/edit?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| id | int | 是 | 礼包名 |
| name | string | 否 | 礼包名 |
| cid | string | 否 | 渠道id |
| sids | string | 否 | 服信息 |
| items | string | 否 | 道具 |
| start_time | int | 否 | 开始时间 |
| end_time | int | 否 | 结束时间 |
| is_band | int | 否 | 是否绑定角色 |
| receive_produce | int | 否 | 允许领取时生成兑换码（活动开始不得修改） |
| status | int | 否 | 状态(关闭：0, 开启：1, 暂停：2) |
| desc | string | 否 | 描述 |

curl测试命令:`curl -d "id=1&name=100个cdkey测试&cid=12&sids=1,2,3,4&start_time=1517155200&end_time=1543593600&status=1" "http://127.0.0.1:9899/api/giftbag/edit?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 4.4追加礼券
方式：`POST`

地址：`http://127.0.0.1:9899/api/giftbag/increase?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| id | int | 是 | 礼包ID |
| product_count | int | 是 | 生成数量 |

curl测试命令:`curl -d "id=1&product_count=100" "http://127.0.0.1:9899/api/giftbag/increase?time=1517539152&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 4.5礼包详情
方式：`GET`

地址：`http://127.0.0.1:9899/api/giftbag/detail?time=1517539152&id=1&sign=b9a45ec4ed8e640b767d02b67174b02e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| id | int | 是 | 礼包id |

curl测试命令:`curl "http://127.0.0.1:9899/api/giftbag/detail?time=1517539152&id=1&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 4.6领取礼券
方式：`POST`

地址：`http://127.0.0.1:9898/api/cdkey/receive?time=1517539152&sign=3c031ee08db6270190e1fc9646b6aa8e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| code | string | 是 | 礼包码 |
| pid | int | 是 | 角色id |

curl测试命令:`curl -d "code=GB&pid=123456" "http://127.0.0.1:9898/api/cdkey/receive?time=1517539152&sign=3c031ee08db6270190e1fc9646b6aa8e"`

### 4.7使用礼券
方式：`POST`

地址：`http://127.0.0.1:9898/api/cdkey/use?time=1517539152&sign=3c031ee08db6270190e1fc9646b6aa8e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| code | string | 是 | 兑换码 |
| pid | int | 是 | 角色id |

curl测试命令:`curl -d "code=009AHB03W7GT&pid=123456" "http://127.0.0.1:9898/api/cdkey/use?time=1517539152&sign=3c031ee08db6270190e1fc9646b6aa8e"`

### 4.8礼券列表
方式：`GET`

地址：`http://127.0.0.1:9899/api/cdkey/list?time=1517539152&code=0036GBTM96AJ&sign=b9a45ec4ed8e640b767d02b67174b02e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| giftbag_id | int | 是 | 礼包id |
| batch | int | 否 | 批次 |
| status | int | 否 | 状态 |
| player_id | int | 否 | 玩家id |
| offset | int | 否 | 开始 |
| limit | int | 否 | 数量 |

curl测试命令:`curl "http://127.0.0.1:9899/api/cdkey/list?giftbag_id=1&limit=10&time=1517539152&code=0036GBTM96AJ&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 4.9礼券下载
方式：`GET`

地址：`http://127.0.0.1:9899/api/cdkey/download?time=1517539152&code=0036GBTM96AJ&sign=b9a45ec4ed8e640b767d02b67174b02e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| giftbag_id | int | 是 | 礼包id |
| batch | int | 是 | 批次 |

curl测试命令:`curl "http://127.0.0.1:9899/api/cdkey/download?giftbag_id=1&batch=1&time=1517539152&&sign=b9a45ec4ed8e640b767d02b67174b02e"`

### 5.0礼券详情
方式：`GET`

地址：`http://127.0.0.1:9899/api/cdkey/detail?time=1517539152&code=0036GBTM96AJ&sign=b9a45ec4ed8e640b767d02b67174b02e"`

参数:

| 参数 | 类型 | 必要 | 描述 |
| :--- | :--- | :--- | :--- |
| code | string | 是 | 兑换码 |

curl测试命令:`curl "http://127.0.0.1:9899/api/cdkey/detail?time=1517539152&code=0036GBTM96AJ&sign=b9a45ec4ed8e640b767d02b67174b02e"`
