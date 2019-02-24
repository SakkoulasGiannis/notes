<template>
<div>
  
  <div class="container mt-5">
    <div class="row">
      
      <div class="col-md-6 offset-md-3">
        <h1 class="mb-3">Notes</h1>
        <span class="createNote pt-3 pb-3" v-if='!createNote' @click="createNote = true; stopNoteEdit();"><i class="fas fa-plus"></i> Take a note...</span>
       
        <ul class="list-group mt-4">

        <form :style="{ 'background-color': '#'+add_note_color }" class="card mt-3 mb-3" v-if='createNote' action="post" @submit.prevent="addToList" >
          <input type="text"    class="form-control" v-model="add_note_title" placeholder="Add a title" aria-label="τιτλε" aria-describedby="button-addon2">
          <textarea name="description" v-model="add_note_description" id="" cols="30" rows="4" placeholder="Add a description" ></textarea>
            <div class="text-right">
              <button class="m-1 btn btn-default card-link done"  >Done</button>
            </div>
            <ul  class="colorPallet">
              <li v-for="(c,i) in colors" :style="{ 'background-color': '#'+c }" v-on:click="add_note_color = c;"></li>
            </ul>
        </form>


          <li v-for='(l,i) in reverseNotes'    @dblclick="l.edit = true; createNote = false; stopNoteEdit(l)"  :style="{ 'background-color': '#'+l.color }" class="list-group-item d-flex justify-content-between align-items-center mb-4">
            <form  v-if='l.edit'  class=" editNote "   action="post" @submit.prevent="editNote(l)" >
              <input type="text" :style="{ 'background-color': '#'+l.color }"  class="" v-model="l.title" placeholder="Add a title" aria-label="title" aria-describedby="button-addon2">
              <textarea  :style="{ 'background-color': '#'+l.color }" name="description" v-model="l.description" id="" cols="130" rows="4" placeholder="Add a description" ></textarea>
              <div class="text-right">
                <button class="btn btn-default card-link done">Done</button>
              </div>
            </form>


            
            <ul v-if='!l.edit' class="colorPallet">
              <li v-for="(c,i) in colors" :style="{ 'background-color': '#'+c }" v-on:click="l.color = c; updateNoteColor(l);"></li>
            </ul>
           
            <div v-if='!l.edit'>
              <span v-if="l.title" class="noteTitle pb-2">
                {{l.title}}
              </span>
              
              <span v-html="l.description"></span>
            </div>

           
            <span v-if='!l.edit' class="badge ">
              <div class="btn-group pointer" role="group">
                <i  v-on:click="removeFromList(l)" class="far fa-trash-alt" ></i>
              </div>
            </span>
          </li>
        </ul>
      <small>*Double Click to Edit</small><br/>
      <small>created by  sakkoulas@gmail.com</small>
      </div>
    </div>
  </div>


</div>
</template>


<script>




export default {
    components: { },
    data () {
      return {
        colors: {
          blue: '519ec3',
          lblue: 'ec3583',
          yellow: 'FFCB3F',
          lyellow: 'FBE6C0',
          red: 'D04931'

        },

        createNote: false,
        
        add_note_color: 'ffffff',
        add_note_title: null,
        add_note_description: null,
        notes: []
      }
  },
  methods: {
    addToList() {
      
      if(!this.add_note_description && !this.add_note_title)
      {
        this.createNote = false;
        this.add_note_title = null;
        this.add_note_description = null;
        return false ;
        
      }
       
      const baseURI = './api/list/create'
      this.$http.post(baseURI, {title: this.add_note_title, description: this.add_note_description, color: this.add_note_color,})
      .then((result) => {
        this.loadList();
      })

      // clear input field
      this.add_note_title = null;
      this.add_note_color = 'ffffff';
      this.add_note_description = null;
      this.createNote = false;
    },
    removeFromList(l){
      
      if (confirm('Are you sure you want to remove this note from your list?')) {
          this.$http.delete('api/list/'+l.id+'/destroy')
          .then((result) => {
           this.loadList();
          })
      } else {
          // Do nothing!
      }

    },
    updateNoteColor(l){
      
      this.$http.post('api/list/'+l.id+'/update' , l)
      .then((result) => {
        this.loadList();
        
        
      })
    },
    editNote(l){
      l.edit = false;
      this.$http.post('api/list/'+l.id+'/update' , l)
      .then((result) => {
        this.loadList(); 
      })
      
    },
    loadList(){
      this.$http.get('./api/list')
      .then((result) => {
        console.log('reload')
        this.notes = result.data;
        console.log(result.data);
      })
    },
    stopNoteEdit(l = null){
      for(let i = 0; i < this.notes.length; i++){

    if(l && l.id == this.notes[i].id){
       continue;
    }

   this.notes[i].edit = false;

}


    }

    // updateItem(id){
    //    this.$http.post('./api/list/'+id+'/update',{title: 'sdf'})
    //   .then((result) => {
    //     console.log(result.data);
    //   })
    //   this.title = null;
    // }
    
    
  },
  mounted: function(){
      this.loadList();
  },
  computed: {
      reverseNotes() {
          return this.notes.slice().reverse();
    }     
  }
    

}
</script>

<style>
.pointer{
  cursor: pointer;
}
h1{
  font-family: 'Open Sans', sans-serif;
}
body{
  font-family: 'Quicksand', sans-serif;
  font-size: 14px;
}
.btn.btn-default:hover {
    background: #eee;
}

.createNote {
  cursor: pointer;
}

span.noteTitle {
    display: block;
}

li input[type="text"] {
    width: 100%;
    font-size: 22px;
    font-weight: lighter;
    border: none;
}

textarea:focus,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
textarea:focus,
.uneditable-input:focus {   
  border-color: none;
  box-shadow: none;
  outline: 0 none;
}

li.list-group-item:hover {
    box-shadow: 8px 8px 12px rgba(0, 0, 0, 0.15), 4px 4px 6px rgba(0,0,0,0.22);
}

li.list-group-item {
    transition: all 0.2s ease;
}

 

textarea {
    font-size: 14px;
    padding-left: 12px;
}
.editNote textarea {
    padding-left: 0;
}

.editNote input[type="text"] {
    border-bottom: dotted 2px #eee;
    width: 100%;
    margin-bottom: 2px;
    font-size: 14px;
}

input.form-control {
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: dotted 2px #eee;
    border-radius: 0;
}

textarea {
    width: 100%;
    border: none;
}
ul.colorPallet, form.colorPallet {
    position: absolute;
    right: 0;
    list-style: none;
    padding-left: 0;
    top: -22px;
    display: none;
    padding-left: 11px;
    padding-right: 11px;
}

ul.colorPallet li, form.colorPallet {
    margin: 3px;
    display: inline-block;
    padding: 7px;
    border-radius: 50%;
    cursor: pointer;
    border: solid 1px #fff;
    
}
ul.list-group li:hover .colorPallet, form:hover .colorPallet {
    display: inline;
}


</style>


