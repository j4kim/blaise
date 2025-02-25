<script setup>
import { Column, DataTable, IconField, InputIcon, InputText } from "primevue";
import { useArticlesStore } from "../../stores/articles";
import { formatDate } from "../../tools";
import { ref } from "vue";

const store = useArticlesStore();

const search = ref("");
</script>

<template>
    <div>
        <DataTable
            :value="store.lines"
            paginator
            :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="gammes {first} à {last} sur {totalRecords}"
            :alwaysShowPaginator="false"
            sortField="name"
            :sortOrder="1"
            :filters="{
                global: {
                    value: search,
                },
            }"
            :globalFilterFields="['name']"
        >
            <template #header>
                <div class="flex justify-end gap-3">
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText
                            v-model="search"
                            placeholder="Filtrer"
                            size="small"
                            variant="filled"
                        />
                    </IconField>
                </div>
            </template>
            <template #empty> Aucune marque trouvée </template>
            <Column
                field="created_at"
                header="Création"
                bodyClass="tabular-nums w-32"
                sortable
            >
                <template #body="slotProps">
                    {{ formatDate(slotProps.data.created_at) }}
                </template>
            </Column>
            <Column field="name" header="Nom" sortable></Column>
            <Column
                field="articles_count"
                header="Articles"
                sortable
                bodyClass="tabular-nums w-28"
            ></Column>
        </DataTable>
    </div>
</template>
