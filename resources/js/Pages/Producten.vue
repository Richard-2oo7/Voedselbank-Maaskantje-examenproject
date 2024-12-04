
<script setup>
import { ref } from 'vue';
defineProps({
  product: Object,
})
// Table headers and rows
const headers = ref(['ProductNr', 'Naam', 'Houdbaarheidsdatum', 'Categorie', 'Aantal op voorraad']);

const rows = ref([
  { ProductNr: 1, Naam: 'Appel', Houdbaarheidsdatum: '2024-01-01', Categorie: 'Fruit', 'Aantal op voorraad': 10 },
  { ProductNr: 2, Naam: 'Brood', Houdbaarheidsdatum: '2023-12-15', Categorie: 'Bakery', 'Aantal op voorraad': 5 },
  { ProductNr: 3, Naam: 'Melk', Houdbaarheidsdatum: '2023-12-10', Categorie: 'Dairy', 'Aantal op voorraad': 8 },
]);

// ProductNr tracker for new products
let nextProductNr = ref(4);

// Add product function
function addProduct() {
  rows.value.push({
    ProductNr: nextProductNr.value++,
    Naam: 'Nieuw Product',
    Houdbaarheidsdatum: '2024-01-01',
    Categorie: 'Onbekend',
    'Aantal op voorraad': 0,
  });
}

// Delete selected products
const selectedProducts = ref([]);

function deleteProducts() {
  rows.value = rows.value.filter(row => !selectedProducts.value.includes(row.ProductNr));
  selectedProducts.value = []; // Clear selection after deletion
}

// Toggle product selection
function toggleSelection(productNr) {
  const index = selectedProducts.value.indexOf(productNr);
  if (index > -1) {
    selectedProducts.value.splice(index, 1);
  } else {
    selectedProducts.value.push(productNr);
  }
}
</script>

<template>
  <div>
    <!-- Add/Delete Product Buttons -->
    <div class="actions">
      <button @click="addProduct" class="add-button">Voeg Product Toe</button>
      <button @click="deleteProducts" class="delete-button" :disabled="selectedProducts.length === 0">Verwijder Product</button>
    </div>

    <!-- Render table dynamically -->
    <table>
      <thead>
        <tr>
          <th>Selecteer</th>
          <th v-for="header in headers" :key="header">{{ header }}</th>
          <th>Acties</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in rows" :key="row.ProductNr">
          <!-- Checkbox for selecting rows -->
          <td>
            <input
              type="checkbox"
              :value="row.ProductNr"
              @change="toggleSelection(row.ProductNr)"
              :checked="selectedProducts.includes(row.ProductNr)"
            />
          </td>
          <!-- Render table row -->
          <td v-for="(value, key) in row" :key="key">{{ value }}</td>
          <!-- Increment/Decrement Stock Buttons -->
          <td>
            <button @click="row['Aantal op voorraad'] > 0 && row['Aantal op voorraad']--">➖</button>
            <button @click="row['Aantal op voorraad']++">➕</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* Add/Delete Product Buttons */
.actions {
  margin-bottom: 20px;
}

.add-button,
.delete-button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  color: white;
  font-size: 14px;
  cursor: pointer;
}

.add-button {
  background-color: #f7941d;
  margin-right: 10px;
}

.delete-button {
  background-color: #d9534f;
}

.delete-button:disabled {
  background-color: #aaa;
  cursor: not-allowed;
}

/* Table Styles */
table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f4f4f4;
  font-weight: bold;
}
</style>