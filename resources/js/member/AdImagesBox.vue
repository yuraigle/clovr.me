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
              <img :src="hash2img(hash)" alt="img"/>
            </div>

            <label
              class="btn btn-link text-decoration-none ps-3"
              :class="{ disabled: uploading }"
              style="height: 100px; width: 100px"
            >
              <span style="line-height: 85px">
                <span class="spinner-border" role="status" v-if="uploading">
                  <span class="visually-hidden">Loading...</span>
                </span>
                <span v-else>
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24"
                       height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="15" y1="8" x2="15.01" y2="8"/>
                    <rect x="4" y="4" width="16" height="16" rx="3"/>
                    <path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5"/>
                    <path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2"/>
                  </svg>
                  Add
                </span>
              </span>

              <input
                id="picture1"
                type="file"
                class="d-none"
                accept="image/*"
                @change="addImg"
              />
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
              <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-brand-youtube" width="24"
                     height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <rect x="3" y="5" width="18" height="14" rx="4"/>
                  <path d="M10 9l5 3l-5 3z"/>
                </svg>
              </span>
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
import {ref} from "vue";
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default {
  props: ["pictures", "youtube", "errors"],
  emits: ["update:pictures", "update:youtube"],

  setup(props, {emit}) {
    const pictures1 = ref(props.pictures);
    const uploading = ref(false);

    function hash2img(s) {
      return "/images/" + s.substring(0, 4) + "/s_" + s + ".webp";
    }

    function addImg(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      if (files[0].size > 4 * 1024 * 1024) {
        showToast('Maximum file size to upload is 4MB');
        return;
      }

      const body = new FormData();
      body.append("pic", files[0]);

      uploading.value = true;
      axios.post('/image-upload', body)
        .then((res) => {
          if (res.status === 200) {
            pictures1.value.push(res.data.hash);
            emit("update:pictures", pictures1.value);
          }
        })
        .catch((err) => showError(err))
        .finally(() => {
          uploading.value = false;
          document.getElementById("picture1").value = null;
        });

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
