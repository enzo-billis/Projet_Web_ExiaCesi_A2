<template>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
            <i class="fa fa-bell-o" aria-hidden="true"></i>  Notifications <span id='badge' class="badge badge-info">{{notifications.length}}</span> <span class="caret"></span>
         </a>

         <ul class="dropdown-menu" role="menu">
            <li style="text-align:center" v-for="notification in notifications">
                <a href="#" v-on:click="MarkAsRead(notification)">
                    {{notification.data.idea.name}} a été validée !<br>
                 </a>
            </li>
             <li style="text-align: center" v-if="notifications.length==0">
              Aucune notification !
             </li>
         </ul>
     </li>
</template>

<script>

    export default {
        props: ['notifications'],
        methods: {
            MarkAsRead: function (notification) {
                var data = {
                    id: notification.id
                };
                axios.post('/notification/read', data).then(response => {
                    window.location.href = "/manif/";
                });
            }
        }
    }
</script>
