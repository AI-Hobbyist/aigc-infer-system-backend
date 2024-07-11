# aigc-infer-system-backend
(开发中)AI在线推理平台。适用于TTS、SVC等等的在线推理，此仓库为后端。

**推理前端：**[https://github.com/AI-Hobbyist/aigc-infer-system-infer](https://github.com/AI-Hobbyist/aigc-infer-system-infer)

**平台后台：**[https://github.com/AI-Hobbyist/aigc-infer-system-control-panel](https://github.com/AI-Hobbyist/aigc-infer-system-control-panel)

<!-- **后端开发/维护：**[红血球AE3803](https://github.com/Erythrocyte3803) -->
## 后端开发/维护：
 - @Erythrocyte3803

## 接口列表

**注：** 请求数据格式将在后端开发完成后更新

### 用户操作

|     描述     |  请求地址   | 请求方式 |
| :----------: | :---------: | :------: |
|   用户登录   | /user/login |   POST   |
|   用户登出   | /user/logout |   POST   |
|   刷新访问令牌   | /user/token/access |   POST   |
| 获取登录信息 |    /user    |   GET    |
|   获取令牌状态   | /user/token/status |   GET   |

### 推理操作

|      描述      |    请求地址     | 请求方式 |
| :------------: | :-------------: | :------: |
| 获取说话人列表 | /infer/spks |   GET    |
|  推理  |   /infer/gen    |   POST   |

### 管理操作

|       描述       |          请求地址          | 请求方式 |
| :--------------: | :------------------------: | :------: |
|     列出用户     |        /admin/users        |   GET    |
|     设为管理     |   /admin/user/{uid}/set    |   POST   |
|     取消管理     |  /admin/user/{uid}/unset   |   POST   |
|   添加推理后端   |     /admin/server/add      |   POST   |
| 列出所有推理后端 |       /admin/servers       |   GET    |
|   更新推理后端   | /admin/server/{sid}/update |   POST   |
|   删除推理后端   | /admin/server/{sid}/delete |   POST   |
