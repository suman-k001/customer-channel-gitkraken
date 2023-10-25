<script src="./DefaultJs.js"></script>

<template>

  <div class="container is-fluid is-paddingless">

    <!--columns-->
    <div class="columns">
      <div class="column is-2">
        <AsideMenu/>
      </div>

      <div class="column is-10">
<span>this is vue default</span>
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

