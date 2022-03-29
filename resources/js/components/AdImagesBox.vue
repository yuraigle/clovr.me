<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Pictures</div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-9 col-md-8">
            <div
              v-for="hash in pictures1"
              :key="hash"
              class="d-inline-block img-thumbnail me-1 mb-1"
            >
              <button
                type="button"
                class="btn-close"
                title="Remove"
                @click="removeImg(hash)"
              >
                &nbsp;
              </button>
              <img :src="hash2img(hash)" alt="img" />
            </div>

            <label
              class="btn btn-link text-decoration-none ps-3"
              :class="{ disabled: uploading }"
              style="height: 100px"
            >
              <span style="line-height: 85px">
                <i class="fa-solid fa-spinner" v-if="uploading"></i>
                <i class="fa-solid fa-camera-retro" v-else></i>
                Add image
                <input
                  id="picture1"
                  type="file"
                  class="d-none"
                  accept="image/*"
                  @change="addImg"
                />
              </span>
            </label>
          </div>
          <div class="col-lg-3 col-md-4 lh-sm">
            <small class="text-muted">
              You can add up to <strong>10 images</strong>. Upload as many clear images as
              possible; this will get your ad more views and replies!
            </small>
          </div>
        </div>

        <div class="d-md-flex border-top pt-3 mt-2">
          <label class="col-form-label me-4" for="youtube">
            Add a YouTube video link:
          </label>
          <div class="flex-grow-1">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-brands fa-youtube"></i></span>
              <input
                type="text"
                id="youtube"
                class="form-control"
                :class="{ 'is-invalid': errors.youtube.$error }"
                :value="youtube"
                @input="$emit('update:youtube', $event.target.value)"
                placeholder="https://www.youtube.com/watch?v=K69tbUo3vGs"
              />

              <span class="invalid-feedback" v-if="errors.youtube.$error">
                {{ errors.youtube.$errors[0].$message }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";

export default {
  props: ["pictures", "youtube", "errors"],
  emits: ["update:pictures", "update:youtube"],

  setup(props, { emit }) {
    const pictures1 = ref(props.pictures);
    const uploading = ref(false);

    function hash2img(s) {
      return "/images/" + s.substring(0, 4) + "/s_" + s + ".webp";
    }

    function addImg(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        uploading.value = true;

        const formData = new FormData();
        formData.append("pic", files[0]);

        fetchApi(
          "/image-upload",
          {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrf() },
            body: formData,
          },
          (resp) => {
            pictures1.value.push(resp.hash);
            emit("update:pictures", pictures1.value);
          },
          () => {
            uploading.value = false;
            document.getElementById("picture1").value = null;
          }
        );
      }
    }

    function removeImg(hash) {
      for (let i = 0; i < pictures1.value.length; i++) {
        if (pictures1.value[i] === hash) {
          pictures1.value.splice(i, 1);
        }
      }
      emit("update:pictures", pictures1.value);
    }

    return {
      pictures1,
      uploading,
      hash2img,
      addImg,
      removeImg,
    };
  },
};
</script>

<style scoped>
.img-thumbnail {
  position: relative;
}
.img-thumbnail > .btn-close {
  background-color: #8a848d;
  position: absolute;
  top: 0;
  right: 0;
}
</style>
