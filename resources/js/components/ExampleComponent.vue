<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading" id="accordion">
                        <span class="glyphicon glyphicon-comment">
                             {{ aUser.status }}
                            <span v-if="aUser.status === 'offline'">
                              <img :src="'icons/status-offline.png'"/>
                            </span>
                            <span v-else-if="aUser.status === 'online'">
                              <img :src="'icons/status-online.png'"/>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
  export default {
    props: ['user', 'user2'],
    data() {
      return {
        aUser: this.user2,
      };
    },
    mounted() {
      this.listen();
      this.listenForWhisper();
    },
    methods: {
      listen() {
        Echo.join('chat').joining((user) => {
          axios.put('/api/user/' + user.id + '/online?api_token=' + user.api_token, {});
        }).leaving((user) => {
          axios.put('/api/user/' + user.id + '/offline?api_token=' + user.api_token, {});
        }).listen('UserOnline', (e) => {
          this.aUser = e.user;
        }).listen('UserOffline', (e) => {
          this.aUser = e.user;
        });
      },
    },
  };
</script>
