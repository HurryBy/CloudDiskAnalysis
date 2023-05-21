<template>
  <div id="app">
      <el-row :gutter="20">
        <el-card class="box-card">
          <div class="demo-basic--circle">
            <div class="block"><el-avatar :size="150" :src="avatar"></el-avatar></div>
          </div>
            <h1>短视频/图集在线去水印解析</h1>
            <div class="typo">
              <p><strong>项目地址 </strong><a href="https://github.com/HurryBy/lanzou-directlink" target="_blank" rel="nofollow"><u>点我跳转</u></a></p>
              <p><strong>目前支持 </strong>123云盘/蓝奏云盘</p>
              <p><strong>温馨提示 </strong><a target="_blank" href="http://www.freecdn.pw/?zzwz" title="免费云加速（FreeCDN），为您免费提供网站加速和网站防御（DDOS、CC攻击）" alt="免费云加速（FreeCDN），为您免费提供网站加速和网站防御（DDOS、CC攻击）">本站由免费云加速（FreeCDN）提供网站加速和攻击防御服务</a></p>
            </div>
            <hr>
            <div class="main" v-loading="isLoading">
              <div class="grid-content">
                  <el-input placeholder="请粘贴分享链接" v-model="link" id="url" lass="input-with-select">
                    <el-select v-model="select" slot="prepend" placeholder="123云盘">
                      <el-option label="123云盘" value="1"></el-option>
                      <el-option label="蓝奏云盘" value="2"></el-option>
                    </el-select>
                    <el-button slot="append" @click="onSubmit" >解析</el-button>
                  </el-input>
                  <el-input placeholder="请输入密码" v-model="password" id="url" lass="input-with-select"></el-input>
              </div>
              <el-table
          :data="tableData"
          border
          style="width: 100%">
          <el-table-column
            prop="name"
            label="文件名"
            width="230">
          </el-table-column>
          <el-table-column
            prop="time"
            label="日期"
            width="150">
          </el-table-column>
          <el-table-column
            prop="size"
            label="大小"
            width="120">
          </el-table-column>
          <el-table-column
            prop="description"
            label="简介"
            width="299">
          </el-table-column>
          <el-table-column
            fixed
            label="操作"
            width="170">
            <template slot-scope="scope">
              <el-button @click="downloadFile(scope.row.url)" type="text" size="small">下载文件</el-button>
              <el-button @click="doUrlCopy()" type="text" size="small">复制直链地址</el-button>
            </template>
    </el-table-column>
        </el-table>
            </div>
        </el-card>
      </el-row>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'App',
  data:function(){
    return{
      link: "",
      password: "",
      isMultiFile: false,
      isLoading:false,
      multiFile:{},
      tableData:[],
      avatar:"https://avatars.githubusercontent.com/u/47547391",
      select:"1",
    }
  },
  methods:{
    onSubmit(){
      this.isMultiFile=false
      this.downloadLink=""
      this.isLoading=true
      var getLink=""
      if(this.password.trim() === ""){
        if(this.select == 1){
          getLink = `../api/123.php?link=${this.link}`
        }
        if(this.select == 2){
          getLink = `../api/lanzou.php?link=${this.link}`
        }
      }else{
        if(this.select == 1){
          getLink = `../api/123.php?link=${this.link}&pwd=${this.password}`
        }
        if(this.select == 2){
          getLink = `../api/lanzou.php?link=${this.link}&pwd=${this.password}`
        }
      }
      axios.get(getLink).then(
        response => {
          if(response.data.code === 200){
            this.$message({
              message: response.data.msg,
              type: 'success'
            })
            this.isLoading=false
            if(response.data.docname === undefined){
              //单文件
              this.$set(this.tableData,0,response.data.data)
            }else{
              //多文件
              this.tableData = response.data.data
              this.isMultiFile = true
            }
          }else{
            this.isLoading=false
            this.$message.error(response.data.msg)
          }
        },
        error => {
          this.isLoading=false
          this.$message.error(error.message)
        }
      )
    },
    downloadFile(downloadUrl){
      window.location.href=downloadUrl
    },
    doUrlCopy(){
      if(this.password === undefined){this.password=""}
      this.$copyText("https://lanzou.humorously.tk/api/api.php?link=" + this.link + "&pwd=" + this.password).then(()=>{
        this.$message({
          message: '复制成功',
          type: 'success'
        })
        },
        ()=>{
        this.$message.error('复制失败');
      })
    }
  }
}
</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin: auto;
    padding: 1em;
    max-width: 900px;
  }

  ::selection {
    background: rgba(0,149,255,.1);
  }

  body:before{
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: .3;
    z-index: -1;
    content: "";
    position: fixed;
  }

  .grid-content {
    margin-top: 1em;
    border-radius: 4px;
    min-height: 50px;
  }

  .el-select .el-input {
    width: 130px;
  }
  .input-with-select .el-input-group__prepend {
    background-color: #fff;

  }

  .box-card {
    margin-top: 4em!important;
    margin-bottom: 4em!important;
    opacity: .8;
  }

  @media screen and (max-width: 700px){
    .box-card {
      margin-top: 1em!important;
      margin-bottom: 1em!important;
    }
  }
  .download h3{
      margin-top: 2em;
    }

  .download button{
    margin-right: 0.5em;
    margin-left: 0.5em;
  }


  .item {
    padding: 5px;
    break-inside: avoid;
  }

  .item img {
    width: 100%;
    margin-bottom: 10px;
  }
  .typo {
    text-align: left;
  }
  .typo a {
    color: #2c3e50;
    text-decoration:none;
  }

  hr{
    height: 10px;
    margin-bottom: .8em;
    border: none;
    border-bottom: 1px solid rgba(0,0,0,.12);
  }
</style>
