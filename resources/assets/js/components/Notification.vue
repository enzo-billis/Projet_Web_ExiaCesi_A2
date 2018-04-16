<template>
  <li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-bell-o" aria-hidden="true"></i> Notifications <span id='badge' class="badge badge-info">{{notifications.length}}</span>
      <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
      <li style="text-align:center" v-for="notification in notifications">

        <a style="margin-bottom: 2em" href="#" v-on:click="markAsRead(notification)">
          {{ name(notification) }}<br>
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
    name: 'notification',
    data() {
      return {
        notifications: {}
      }
    },
    methods: {
      markAsRead: function (notification) {
        var data = {
          id: notification.id
        };
        axios.post('/notification/read', data).then(() => {
          window.location.href = "/home/";
        });
      },

      name(notification) {
        switch(notification.type) {
          case 'App\\Notifications\\PictureSignaled':
            return "La photo #"+notification.data.picture.id+" a été supprimée par "+notification.data.picture.ban_user_id+" pour la raison : "+notification.data.picture.ban_reason
            break;
          case 'App\\Notifications\\IdeaSelected':
            return "Votre idée "+notification.data.idea.name+ " a été validée !"
            break;
          case 'App\\Notifications\\CommentSignaled':
            return "Le commentaie de "+notification.data.comment.id_users+" a été supprimée par "+notification.data.comment.ban_user_id
            break;
        }
      }
    },
    mounted() {
      axios.post('/notification/get').then(response => {
        this.notifications = response.data
      })
    },
  }
</script>
