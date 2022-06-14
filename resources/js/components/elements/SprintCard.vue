<template>

<div class="uk-card uk-width-1-3@m">
   <!-- <div class="btnEditItem">
        <a @click="openPersonEdit()" class="btnEditItem">
            <img class="btnEditItemIcon" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ficons.iconarchive.com%2Ficons%2Fcustom-icon-design%2Fflatastic-1%2F512%2Fedit-icon.png&f=1&nofb=1" alt="">
        </a>
    </div> -->

    <div class="uk-card-header">
        <p class="CardItemName uk-text-center@s uk-text-emphasis uk-text-bolder">{{Sprint_Name}}</p>
    </div>

    <div class="uk-card-body">
        <p class="uk-text-center@s">{{User_Name}}</p>
    </div>
    
</div>
 
</template>

<script>

export default {
        props:{
            Sprint_id:{
                type: Number,
                default: 0
            },
            Sprint_Name:{
                type: String,
                default: "NULL"
            },
            Sprint_UserId:{
                type: Number,
                default: 0
            },
            User_Name:{
                type: String,
                default: "NULL"
            }
        },
        data: () => ({
            
        }),
        mounted(){
           
        },
        methods: {
            openPersonEdit() {
                this.$router.push('/person/'+this.Person_id).catch(()=>{})
            }
        },
        name: "PersonCard"
    }
</script>

<style>
.uk-card-header{
    padding: 10px 20px 15px 20px;
    min-height: 40px;
    max-height: 40px;
}

.uk-card{
    margin: 10px 15px 10px 15px;
    display: block;
    border:1px solid black;
    float: left;
    overflow: hidden;
    border-radius: 7px;
    border-color: #00499c2d;
    background-color: rgba(230, 240, 255, 0.233);
    padding-left:0%; 
    min-width: 300px;
    max-width: 300px;
    min-height: 80px;
    max-height: 80px;
    position:relative;
}

.uk-card:hover{
    background-color: rgba(190, 215, 252, 0.266);
    
}

.uk-grid{
    max-width: 100%;
    margin-left:0%;
    margin-top:0%;
}

.uk-grid+.uk-grid{
    margin-top:0%;
}

.uk-text-emphasis{
    font-size: 16px;
}

.uk-card-body{
    padding: 0 10px;
    min-height: 120px;
    max-height: 120px;
}

.uk-card-footer {
    min-width: 100%;
    max-width: 100%;
    min-height: 40px;
    max-height: 40px;
    padding: 10px 20px 10px 20px;
    position:absolute;
	bottom:0;
}

.CardItemName {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 12pt;
}

.btnEditItem {
    position: absolute;
    z-index:  100;
    margin: 0 0 0 0;
    height: auto;
}

.btnEditItemIcon{
    min-height: 20px; 
    max-height: 20px;
    min-width: 20px;
    max-width: 20px;
}
</style>