<template>
<PageComponent>
    <template v-slot:header>
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ route.params.id === true ? model.title : 'Create a Survey' }}
            </h1>
            <button
                v-if="route.params.id"
                type="button"
                @click="dleleteSurvey()"
                class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red"
            >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 -mt-1 inline-block"
                fill="currentColor"
                viewBox="0 0 20 20"
                >
                <path
                    fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002"
                    clip-rule="evenodd"
                />
            </svg> Delete Survey </button>
        </div>
    </template>
    <div v-if="surveyLoading" class="flex justify-center">Loading...</div>
    <form v-else @submit.prevent="saveSurvey" class="animate-fade-in-down">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Image
                        </label>
                        <div class="mt-1 flex items-center">
                            <img
                                v-if="model.image_url"
                                :src="model.image_url"
                                :alt="model.title"
                                class="w-64 h-48 object-cover" />
                                <span
                                    v-else
                                    class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
                                >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-[80%] w-[80%] text-gray-300"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                </span>
                                <button
                                    type="button"
                                    class="
                                    relative
                                    overflow-hidden
                                    ml-5
                                    bg-white
                                    py-2
                                    px-3
                                    border border-gray-300
                                    rounded-md
                                    shadow-sm
                                    text-sm
                                    leading-4
                                    font-medium
                                    text-gray-700
                                    hover:bg-gray-50
                                    focus:outline-none
                                    focus-ring-2
                                    focus:ring-offset-2
                                    focus:ring-indigo-500"
                                >
                                    <input
                                      type="file"
                                      @change="onImageChoose"
                                      class="absolute
                                      left-0
                                      top-0
                                      right-0
                                      bottom-0
                                      opacity-0
                                      cursor-pointer"
                                    />
                                 Change </button>
                        </div>
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            v-model="model.title"
                            autocomplete="survey_title"
                            class="mt-1
                                   focus:ring-indigo-500 focus:border-indigo-500
                                   block
                                   w-full
                                   shadow-sm
                                   sm:text-sm
                                   border-gray-300
                                   rounded-md"
                            />
                    </div>
                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700">Title</label>
                        <div class="mt-1">
                        <textarea
                            rows="3"
                            name="description"
                            id="description"
                            v-model="model.description"
                            autocomplete="survey_description"
                            placeholder="Describe your survey"
                            class="mt-1
                                   focus:ring-indigo-500 focus:border-indigo-500
                                   block
                                   w-full
                                   sm:text-sm
                                   border border-gray-300
                                   rounded-md"
                            />
                        </div>
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Expire Date</label>
                        <input
                            type="date"
                            name="expire_date"
                            id="expire_date"
                            v-model="model.expire_date"
                            class="mt-1
                                   focus:ring-indigo-500 focus:border-indigo-500
                                   block
                                   w-full
                                   shadow-sm
                                   sm:text-sm
                                   border-gray-300
                                   rounded-md"
                            />
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                                <input
                                    id="status"
                                    name="status"
                                    type="checkbox"
                                    v-model="model.status"
                                    class="
                                        focus:ring-indigo-500
                                        h-4
                                        w-4
                                        text-indigo-600
                                        border-gray-300
                                        rounded
                                    "
                                />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="status" class="font-medium text-gray-700">Active</label>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <h3 class="text-2xl font-semibold flex items-center justify-between">
                        Questions
                        <button type="button"
                                @click="addQuestion()"
                                class="flex
                                       items-center
                                       text-sm
                                       py-1
                                       px-4
                                       rounded-sm
                                       text-white
                                       bg-gray-600
                                       hover:bg-gray-700"
                        > 
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-[80%] w-[80%] text-gray-300"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        Add questions
                        </button>
                    </h3>
                    <div v-if="!model.questions.length" class="text-center text-gray-600">
                        You don't have any questions created
                    </div>
                    <div
                        v-for="(question, index) in model.questions"
                        :key="question.id">
                            <QuestionEditor
                                :question="question"
                                :index="index"
                                @change="questionChange"
                                @addQuestion="addQuestion"
                                @deleteQuestion="deleteQuestion"
                        />
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button
                       type="submit"
                       class="inline-flex
                       justify-center
                       py-2
                       px-4
                       border
                       border-transparent
                       shadow-sm
                       text-sm
                       font-medium
                       rounded-md
                       text-white
                       bg-indigo-600
                       hover:bg-indigo-700
                       focus:outline-none
                       focus:ring-2
                       focus:ring-offset-2
                       focus:ring-indigo-500"
                    > Save </button>
                </div>
            </div>
    </form>
</PageComponent>
</template>

<script setup>
import { v4 as uuidv4 } from "uuid";
import store from "../store"
import { ref, watch, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import PageComponent from "../components/PageComponent.vue"
import QuestionEditor from "../editor/QuestionEditor.vue"

const route = useRoute()

const router =useRouter()

const surveyLoading = computed(() => store.state.currentSurvey.loading)

let model = ref({
    title:"",
    status: false,
    description: null,
    image_url: null,
    expire_date: null,
    questions: []
})

    watch(
        () => store.state.currentSurvey.data,
        (newVal, oldVal) => {
            model.value = {
                ...JSON.parse(JSON.stringify(newVal)),
                status: newVal.status !== "draft"
            }
        }
    )

    if (route.params.id) {
      store.dispatch('getSurvey', route.params.id)
    }

    function addQuestion(index) {
        const newQuestion = {
            id: uuidv4(),
            type: "text",
            question: "",
            description: null,
            data: {}
        }

        model.value.questions.splice(index, 0, newQuestion)
    }

    function deleteQuestions(question) {
        model.value.questions = model.value.questions.filter(
            (q) => q!== question
        )
    }

    function questionChange(question) {
        console.log(model.value.questions)
        model.value.questions = model.value.questions.map((q) => {
            if (q.id === question.id) {
                return JSON.parse(JSON.stringify(question))
            }
        })
        console.log(model.value.questions)
    }

    function saveSurvey() {
        store.dispatch("saveSurvey", model.value).then(({ data }) => {
            store.commit('notify',{
                type: 'success',
                message: 'Survey was successfully updated'
            })
            router.push({
                name:"SurveyView",
                params: {id: data.data.id}
            })
        })
    }

    function onImageChoose (ev) {
        const file = ev.target.files[0]

        const reader = new FileReader()

        reader.onload = () => {
            model.value.image = reader.result
            model.value.image_url = reader.result
        }
        reader.readAsDataURL(file)
    }

    function deleteSurvey() {
        if (confirm('Do you want to delete this survey?')) {
            store.dispatch('deleteSurvey', model.value.id).then(() => {
                router.push({
                    name: 'Surveys'
                })
            })
        }
    }


</script>
