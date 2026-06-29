<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import type { PropType } from 'vue';

const props = defineProps({
    sprints: {
        type: Array as PropType<Array<{
            id: number;
            title: string;
            start_date: string;
            end_date: string;
            target: string;
        }>>,
        default: () => [],
    },
});

const deleteSprint = (id: number) => {
    if (!confirm('Apakah Anda yakin ingin menghapus sprint ini?')) {
        return;
    }

    router.delete(`/sprints/${id}`);
};
</script>

<template>
    <Head title="Sprint" />

    <div class="space-y-6">
        <div class="flex flex-col gap-4 rounded-xl border border-sidebar-border/70 bg-white p-4 shadow-sm dark:border-sidebar-border dark:bg-slate-950">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Sprint</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Daftar sprint yang dimiliki oleh akun Anda.
                    </p>
                </div>

                <Link
                    href="/sprints/create"
                    class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-200"
                >
                    Tambah Sprint
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-900 dark:text-slate-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Judul</th>
                            <th scope="col" class="px-4 py-3">Mulai</th>
                            <th scope="col" class="px-4 py-3">Selesai</th>
                            <th scope="col" class="px-4 py-3">Target</th>
                            <th scope="col" class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white text-sm text-slate-700 dark:divide-slate-700 dark:bg-slate-950 dark:text-slate-200">
                        <tr v-for="sprint in props.sprints" :key="sprint.id">
                            <td class="px-4 py-4">{{ sprint.title }}</td>
                            <td class="px-4 py-4">{{ sprint.start_date }}</td>
                            <td class="px-4 py-4">{{ sprint.end_date }}</td>
                            <td class="px-4 py-4 break-words">{{ sprint.target }}</td>
                            <td class="px-4 py-4 space-x-2">
                                <Link
                                    :href="`/sprints/${sprint.id}/edit`"
                                    class="inline-flex rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                                >
                                    Edit
                                </Link>
                                <button
                                    type="button"
                                    @click="deleteSprint(sprint.id)"
                                    class="inline-flex rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-rose-500"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="props.sprints.length === 0">
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                Belum ada sprint tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Styling tambahan jika diperlukan */
</style>
