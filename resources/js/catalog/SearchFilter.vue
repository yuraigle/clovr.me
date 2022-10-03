<template>
  <section class="container py-2">
    <form class="row">
      <div class="col-auto">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
            Sale
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Sale</a></li>
            <li><a class="dropdown-item" href="#">Rent</a></li>
            <li><a class="dropdown-item" href="#">Share</a></li>
          </ul>
        </div>
      </div>

      <div class="col-auto">
        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle">
          Price
        </button>
      </div>

      <div class="col-auto">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-outline-warning dropdown-toggle" data-bs-toggle="dropdown">
            House
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">House</a></li>
            <li><a class="dropdown-item" href="#">Apartment</a></li>
            <li><a class="dropdown-item" href="#">Garage</a></li>
          </ul>
        </div>
      </div>
    </form>
  </section>
</template>

<script>
export default {
  props: ["filter"],
  emits: ["update:filter"]
}
</script>
