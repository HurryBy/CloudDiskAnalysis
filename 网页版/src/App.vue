<template> 
  <el-container style="solid #eee">
    <el-header>
      <h1>蓝奏云API解析</h1>
    </el-header>
    <el-main>
      <el-input v-model="link" placeholder="请输入解析链接"></el-input>
      <el-input v-model="password" placeholder="请输入解析链接的密码"></el-input>
      <br></br>
      <el-button type="primary" @click="sendRequests(link,password)" :loading="isLoading">点击解析</el-button>
      <br></br>
      <el-table
        :data="tableData"
        border
        style="width: 100%">
        <el-table-column
          fixed
          prop="name"
          label="文件名"
          width="250">
        </el-table-column>
        <el-table-column
          prop="id"
          label="文件ID"
          width="200">
        </el-table-column>
        <el-table-column
          prop="time"
          label="日期"
          width="150">
        </el-table-column>
        <el-table-column
          prop="author"
          label="作者"
          width="120">
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
          label="操作"
          width="340">
          <template slot-scope="scope">
            <el-button @click="downloadFile(scope.row.url)" type="text" size="small">下载文件</el-button>
            <el-button @click="copyUrl(scope.row.url)" type="text" size="small">复制下载地址</el-button>
            <el-button @click="copyDirectUrl(scope.row.id,scope.row.password)" type="text" size="small">复制直链地址</el-button>
          </template>
  </el-table-column>
      </el-table>
    </el-main>
    <el-footer>Hurry 2022-2023 <a href="https://www.github.com/HurryBy/lanzou-directlink">项目地址</a></el-footer>
  </el-container> 
</template>

<script>
import axios from 'axios'
export default {
  name: 'App',
  data:function(){
    return{
      link: "",
      password: "",
      isFirst: true,
      isMultiFile: false,
      isLoading:false,
      multiFile:{},
      tableData:[]
    }
  },
  methods:{
    sendRequests(link,password){
      this.tableData=[]
      this.isFirst=false
      this.isMultiFile=false
      this.downloadLink=""
      this.isLoading=true
      var getLink=""
      if(password.trim() === ""){
        getLink = `../api/api.php?link=${link}`
      }else{
        getLink = `../api/api.php?link=${link}&pwd=${password}`
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
    copyUrl(url){
      this.$copyText(url).then(()=>{
        this.$message({
          message: '复制成功:)',
          type: 'success'
        })
        },
        ()=>{
        this.$message.error('复制失败:(');
      })
    },
    copyDirectUrl(id,pwd){
      if(pwd === undefined){pwd=""}
      this.$copyText("https://lanzou.humorously.tk/api/api.php?link=wwt.lanzouw.com/" + id + "&pwd=" + pwd).then(()=>{
        this.$message({
          message: '复制成功:)',
          type: 'success'
        })
        },
        ()=>{
        this.$message.error('复制失败:(');
      })
    }
  }
}
</script>

<style>
</style>
