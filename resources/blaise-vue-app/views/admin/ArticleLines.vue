<script setup>
import { Column, DataTable } from "primevue";
import { useArticlesStore } from "../../stores/articles";
import { formatDate } from "../../tools";

const store = useArticlesStore();
</script>

<template>
    <div>
        <DataTable
            :value="store.lines"
            paginator
            :rows="5"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="gammes {first} à {last} sur {totalRecords}"
            :alwaysShowPaginator="false"
            sortField="name"
            :sortOrder="1"
        >
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
