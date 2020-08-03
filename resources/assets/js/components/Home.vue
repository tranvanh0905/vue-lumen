<template>
    <div id="home">
        <modal name="my-first-modal">
            <form @submit.prevent="addCategory">
                    <div class="form-group m-2">
                        <label for="">Name:</label>
                        <input
							v-model="name"
                            type="text"
                            class="form-control"
                            placeholder="Please enter your name">
                    </div>
                    <div class="form-group m-2">
                        <label for="">Content:</label>
                        <input
							v-model="content"
                            type="text"
                            class="form-control"
                            placeholder="Please enter your content">
                    </div>
                <div class="form-group m-2">
                    <button class="btn btn-success float-xs-right" type="submit">Submit</button>
                    <span style="color:red" v-for="(error, index) in errors" v-bind:key="index">{{error.body}}</span>
                </div>
            </form>
        </modal>
		 <modal name="edit-modal">
            <form @submit.prevent="editCategory">
				<input type="hidden" name="" v-model='id'>
                    <div class="form-group m-2">
                        <label for="">Name:</label>
                        <input
							v-model="name"
                            type="text"
                            class="form-control"
                            placeholder="Please enter your name">
                    </div>
                    <div class="form-group m-2">
                        <label for="">Content:</label>
                        <input
							v-model="content"
                            type="text"
                            class="form-control"
                            placeholder="Please enter your content">
                    </div>
                <div class="form-group m-2">
                    <button class="btn btn-success float-xs-right" type="submit">Submit</button>
                    <span style="color:red" v-for="(error, index) in errors" v-bind:key="index">{{error.body}}</span>
                </div>
            </form>
        </modal>
        <div style="margin-bottom: 10px;">
            <el-button @click="exportAll" style="margin-right: 10px;">export all</el-button>
            <label >Search:</label>
            <el-input style="width: 200px; margin-left: 20px;" v-model="filters[0].value"></el-input>
            <el-button @click="show" type="success">Add</el-button>
        </div>

        <data-tables :data="data" :pagination-props="{ pageSizes: [5, 10, 15] }" :action-col="actionCol" :filters="filters" >
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
        </data-tables>
    </div>
</template>
<script>
	import axios from 'axios';
	import json2csv from 'json2csv'
	var data, titles
	titles = [{
		prop: "id",
		label: "ID."
	}, {
		prop: "name",
		label: "Name"
	}, {
		prop: "content",
		label: "Content"
	}]
	var CsvExport = function(data, fields, fieldNames, fileName) {
		try {
			var result = json2csv({
				data: data,
				fields: fields,
				fieldNames: fieldNames
			})
			var csvContent = 'data:text/csvcharset=GBK,\uFEFF' + result
			var encodedUri = encodeURI(csvContent)
			var link = document.createElement('a')
			link.setAttribute('href', encodedUri)
			link.setAttribute('download', `${(fileName || 'file')}.csv`)
			document.body.appendChild(link)
			link.click()
			document.body.removeChild(link)
		} catch (err) {
			console.error(err)
		}
	}

	export default {
		name: "Home",
		methods: {
			getCategory() {
				axios.get('./api/category').then((response)=>{
					this.data = response.data.result
					this.data = (this.data).reverse()
				});
			},
			getDetailCategory(id) {
				axios.get('./api/category/' + id).then((response)=>{
					this.name = response.data.result.name;
					this.content = response.data.result.content;
				});
			},
            deleteCategory(id) {
				axios.delete('./api/category/' + id).then((response)=>{
				});
				alert("Delete complete")
            },
			exportAll() {
				CsvExport(this.data, this.columns, this.columnNames, 'all')
			},
			show () {
				this.name = "";
				this.content = "";
				this.$modal.show('my-first-modal');
			},
			hide () {
				this.$modal.hide('my-first-modal');
			},
			showEditModal() {
				this.$modal.show('edit-modal');
			},
            addCategory (event) {
				event.preventDefault();
				axios.post('./api/category/', {
					name: this.name,
					content: this.content
                }).then((response)=>{
					this.data.push({
						name: this.name,
						content: this.content,
						id: response.data.result.id,
           				completed: false,
					});
					this.data = (this.data).reverse()
					this.name = '';
					this.content = '';
					alert("Add complete");
				}).catch(e => {
					this.errors.push(e)
				});
			},
			editCategory (event) {
				event.preventDefault();
				axios.put('./api/category/' + this.id, {
					name: this.name,
					content: this.content
                }).then((response)=>{
					console.log(this.data[this.index]['name'])
					this.data[this.index]['name'] = response.data.name;
					this.data[this.index]['content'] = response.data.name;
					alert("Edit Complete");
				}).catch(e => {
					this.errors.push(e)
				});
			}
		},
		mount () {
			this.show()
		},
		created:function() {
			this.getCategory();
		},
		data() {
			return {
				data: [...new Array(1)].reduce((previous) => {
					return previous.concat(data)
				}, []),
				titles,
				filters: [{
					value: '',
					prop: 'name',
				}, {
					value: []
				}],
				name: '',
				content: '',
				id: '',
				index: '',
				columns: ['id', 'name', 'content'],
				columnNames: ['ID', 'Name', 'Content'],
				actionCol: {
					label: 'Action',
					props: {
						align: 'center',
					},
					buttons: [{
						props: {
							type: 'primary',
							icon: 'el-icon-edit'
						},
						handler: row => {
							this.showEditModal()
							this.getDetailCategory(row.id);
							this.id = row.id;
							this.index = this.data.indexOf(row);
						},
						label: 'Edit'
					}, {
						handler: row => {
							this.deleteCategory(row.id);
							this.data.splice(this.data.indexOf(row), 1)
						},
						label: 'delete'
					}]
				}
			}
		},
	}
</script>
