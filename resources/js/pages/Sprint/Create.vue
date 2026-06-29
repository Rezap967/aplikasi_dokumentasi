<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import type { PropType } from 'vue';
import sprints from '@/routes/sprints';

const props = defineProps({
    sprint: {
        type: Object as PropType<{
            id: number;
            title: string;
            start_date: string;
            end_date: string;
            target: string;
        }> ,
        required: false,
    },
    errors: {
        type: Object as PropType<Record<string, string[]>>,
        required: false,
        default: () => ({}),
    },
});

const form = useForm({
    title: props.sprint?.title ?? '',
    start_date: props.sprint?.start_date ?? '',
    end_date: props.sprint?.end_date ?? '',
    target: props.sprint?.target ?? '',
    objective: props.sprint?.document?.objective ?? '',
    result: props.sprint?.document?.result ?? '',
    obstacle: props.sprint?.document?.obstacle ?? '',
    solution: props.sprint?.document?.solution ?? '',
    next_plan: props.sprint?.document?.next_plan ?? '',
});

const isEdit = Boolean(props.sprint);

const submit = () => {
    if (isEdit && props.sprint) {
        form.put(sprints.update(props.sprint.id).url(), {
            preserveScroll: true,
        });
        return;
    }

    form.post(sprints.store().url(), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Sprint' : 'Buat Sprint'" />

    <div class="space-y-6 rounded-xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:border-sidebar-border dark:bg-slate-950">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ isEdit ? 'Edit Sprint' : 'Buat Sprint' }}</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                {{ isEdit ? 'Perbarui data sprint Anda.' : 'Isi data sprint baru dan simpan.' }}
            </p>
        </div>

        <form @submit.prevent="submit" class="grid gap-6">
            <div class="grid gap-2">
                <label for="title" class="text-sm font-medium text-slate-700 dark:text-slate-200">Judul</label>
                <input
                    id="title"
                    type="text"
                    v-model="form.title"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                />
                <p v-if="errors.title?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.title[0] }}</p>
            </div>

            <div class="grid gap-2 sm:grid-cols-2 sm:items-end">
                <div class="grid gap-2">
                    <label for="start_date" class="text-sm font-medium text-slate-700 dark:text-slate-200">Tanggal Mulai</label>
                    <input
                        id="start_date"
                        type="date"
                        v-model="form.start_date"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.start_date?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.start_date[0] }}</p>
                </div>

                <div class="grid gap-2">
                    <label for="end_date" class="text-sm font-medium text-slate-700 dark:text-slate-200">Tanggal Selesai</label>
                    <input
                        id="end_date"
                        type="date"
                        v-model="form.end_date"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.end_date?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.end_date[0] }}</p>
                </div>
            </div>

            <div class="grid gap-2">
                <label for="target" class="text-sm font-medium text-slate-700 dark:text-slate-200">Target</label>
                <textarea
                    id="target"
                    v-model="form.target"
                    rows="4"
                    class="min-h-[120px] w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                />
                <p v-if="errors.target?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.target[0] }}</p>
            </div>

            <div class="grid gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-900">
                <div class="space-y-2">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Dokumentasi Sprint</h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Isi objective, result, obstacle, solution, dan next plan untuk sprint ini.</p>
                </div>

                <div class="grid gap-2">
                    <label for="objective" class="text-sm font-medium text-slate-700 dark:text-slate-200">Objective</label>
                    <textarea
                        id="objective"
                        v-model="form.objective"
                        rows="3"
                        class="min-h-[96px] w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.objective?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.objective[0] }}</p>
                </div>

                <div class="grid gap-2">
                    <label for="result" class="text-sm font-medium text-slate-700 dark:text-slate-200">Result</label>
                    <textarea
                        id="result"
                        v-model="form.result"
                        rows="3"
                        class="min-h-[96px] w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.result?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.result[0] }}</p>
                </div>

                <div class="grid gap-2">
                    <label for="obstacle" class="text-sm font-medium text-slate-700 dark:text-slate-200">Obstacle</label>
                    <textarea
                        id="obstacle"
                        v-model="form.obstacle"
                        rows="3"
                        class="min-h-[96px] w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.obstacle?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.obstacle[0] }}</p>
                </div>

                <div class="grid gap-2">
                    <label for="solution" class="text-sm font-medium text-slate-700 dark:text-slate-200">Solution</label>
                    <textarea
                        id="solution"
                        v-model="form.solution"
                        rows="3"
                        class="min-h-[96px] w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.solution?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.solution[0] }}</p>
                </div>

                <div class="grid gap-2">
                    <label for="next_plan" class="text-sm font-medium text-slate-700 dark:text-slate-200">Next Plan</label>
                    <textarea
                        id="next_plan"
                        v-model="form.next_plan"
                        rows="3"
                        class="min-h-[96px] w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-800"
                    />
                    <p v-if="errors.next_plan?.length" class="text-sm text-red-600 dark:text-red-500">{{ errors.next_plan[0] }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-col gap-2 text-sm text-slate-600 dark:text-slate-400">
                    <span class="font-medium">Mode:</span>
                    <span>{{ isEdit ? 'Edit existing sprint' : 'Create a new sprint' }}</span>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <Link
                        :href="sprints.index().url()"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2 text-sm font-medium text-white transition hover:bg-slate-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-200"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped>
textarea {
    resize: vertical;
}
</style>
