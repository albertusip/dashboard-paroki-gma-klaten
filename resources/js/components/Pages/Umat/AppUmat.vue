<template>
    <v-container class="my-5">
        <v-card>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12 sm3>
                        <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm5>
                        <v-select
                        label="Pilih Wilayah"
                        :menu-props="{offsetY: true}"
                        v-model="pickedOutlet"
                        :items="outlets"
                        item-text="name"
                        item-value="id"
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm4 text-xs-right>
                        <v-btn color="primary black--text" @click="dialogAdd = true">
                            Tambah Umat
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-container>
            <v-data-table
                :headers="headers"
                :items="discounts"
                :search="search"
                disable-initial-sort
                :rows-per-page-items="[10]"
                >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.age }}</td>
                    <td class="text-xs-left">{{ props.item.gender }}</td>
                    <td class="text-xs-left">{{ props.item.lingkungan }}</td>
                    <td class="layout px-0 text-xs-center">
                        <v-tooltip bottom>
                            <v-btn icon flat color="orange" slot="activator" @click="editItem(props.item)">
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <span>Ubah</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <v-btn icon flat color="red" slot="activator" @click="deleteItem(props.item)">
                                <v-icon>delete</v-icon>
                            </v-btn>
                            <span>Hapus</span>
                        </v-tooltip>
                    </td>
                </template>
                <v-alert slot="no-results" :value="true" color="error" icon="warning">
                    Your search for "{{ search }}" found no results.
                </v-alert>
            </v-data-table>
        </v-card>
    </v-container>    
</template>
<script>
export default {
    data () {
        return {
            headers: [
            {
                text: 'Nama',
                align: 'left',
                sortable: true,
                value: 'name'
            },
            { text: 'Umur', value: 'age' },
            { text: 'Jenis Kelamin', value: 'Gender' },
            { text: 'Lingkungan', value: 'lingkungan' },
            ],
        }
    }
}
</script>
