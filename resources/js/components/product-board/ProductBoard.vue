<template>
<div class="row">
  <div class="col-md-12 mb-3">
    <div class="row">
      <div class="col-md-6">
        <div class="row" v-if="this.loggedIn == '1'">
          <label class="col-sm-2 col-form-label font-weight-bold">Customer</label>
          <div class="col-sm-10">
            <select
            ref="customerSelect"
            @change="checkSelectedCustomer($event)"
            class="form-control">
              <option selected disabled value="">Please select customer</option>               
              <option v-for="customer in customers" :value="customer.id">{{ customer.name }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6 text-end">
        <button 
        @click="openCart()"
        type="button" class="btn btn-primary position-relative">
          <i class="fa-solid fa-cart-shopping"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ cart.length }}
          </span>
        </button>  
      </div>
    </div>
  </div>
  <div 
  v-if="isLoading"
  class="text-center mt-5">
    <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div v-for="product in products" class="col-md-3 mb-5">
    <div class="card">
      <img class="card-img-top" :src="product.image_link" :alt="product.name">
      <div class="card-body">
        <p class="card-text">
          <strong>{{ product.name }}</strong>
        </p>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <a 
                @click="addToCart(product)"
                type="button" class="text-primary cursor-pointer">
                  <strong>Add to Cart</strong>
                </a>
              </div>
              <div class="col-md-6 col-sm-12 text-end">
                <button 
                @click="updateQuantity('minus', product)"                
                class="btn btn-primary text-white btn-sm">
                  <i class="fa-solid fa-minus"></i>
                </button>
                &nbsp;
                  <span><strong>{{ product.quantity }}</strong></span>
                &nbsp;
                <button 
                @click="updateQuantity('add', product)"
                class="btn btn-primary text-white btn-sm">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Cart -->
<div ref="cartModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cart Details</h5>
        <button 
        @click="closeCart()"
        type="button" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in cart">
                <td>
                  <img class="img-thumbnail" width="100" :src="item.product.image_link" :alt="item.product.name">
                </td>
                <td>{{ item.product.name }}</td>
                <td>
                  <button 
                  @click="updateQuantity('minus', item)"                
                  class="btn btn-primary text-white btn-sm">
                    <i class="fa-solid fa-minus"></i>
                  </button>  
                  &nbsp;
                  {{ item.quantity }}
                  &nbsp;
                  <button 
                  @click="updateQuantity('add', item)"
                  class="btn btn-primary text-white btn-sm">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </td>
                <td>
                  <button 
                  @click="removeItem(item)"
                  data-toggle="tooltip" data-placement="top" title="Remove Item" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-xmark"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="!cart.length">
                <td colspan="4" align="center"><small class="text-muted">Cart is empty</small></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="closeCart()">Close</button>
        <button 
        @click="saveOrder()"
        v-if="cart.length" 
        :disabled="isSubmitting"
        type="button" class="btn btn-primary">
          <i 
          v-if="isSubmitting"
          class="fa-solid fa-spinner fa-spin"></i>
          Save Order
        </button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2'
export default {

  props: {
    loggedIn: {
      type: Number,
      default: 0
    }
  },

  data: () => ({
    
    customer: "",
    cart: [],
    cartModal: "",

    customers: [],
    products: [],

    toastOption: {
      hideProgressBar: true,
      position: "bottom-right",
      theme: "colored",
    },

    isSubmitting: false,
    isLoading: false
  }),

  mounted() {
    this.init();
  },

  methods: {
    init() {
      this.cartModal = $(this.$refs["cartModal"]);      
      this.getCustomers();
      this.getProducts();
    },

    getCustomers() {
      axios.get("/customers/all")
        .then((res) => {
          let result = res.data.customers;
          this.customers = result.map((i) => {
            return { ...i, name: `${i.firstname} ${i.lastname}` }
          });
        });
    },

    getProducts() {
      this.isLoading = true;
      axios.get("/products/all")
        .then((res) => {
          this.products = res.data.products.map((i) => {
            return { ...i, quantity: 1 };
          });
        }).finally(() => {
          this.isLoading = false;
        });
    },

    checkSelectedCustomer(event) {
      const value = event.target.value;
      if(!this.customer) {
        this.customer = value;
      }
      if(this.customer != value && this.cart.length) {
        Swal.fire({
          title: 'Change Customer?',
          text: "Are you sure to change the customer?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirm'
        }).then((result) => {
          if (result.isConfirmed) {
            toast.info(`Customer has been changed`, this.toastOption);
            this.customer = value;
          } else {
            this.$refs["customerSelect"].value = this.customer;
          }
        });
      }
    },
    
    updateQuantity(type, item) {
      if(type == "add") {
        item.quantity = item.quantity + 1; 
      } else {
        /** from cart */ 
        if(item.product && item.quantity == 1) {
          this.removeItem(item);
        } else {
          if(item.quantity > 1) {
            item.quantity = item.quantity - 1;
          }
        }
      }
    },

    removeItem(item) {
      const index = this.cart.findIndex((i => i.product_id == item.product_id));
      this.cart.splice(index, 1);
    },

    addToCart(item) {

      if(this.loggedIn == 0) {
        window.location.href = "/login";
      }

      if(!this.customer) {
        toast.warning("Please select customer before adding items.", this.toastOption);
        return;
      }
      if(!this.cart.length) {
        this.cart.push({
          product_id: item.id,
          product: item,
          quantity: item.quantity
        });
      } else {
        const index = this.cart.findIndex((i => i.product_id == item.id));
        if(index >= 0) {
          this.cart[index].quantity += item.quantity; 
        } else {
          this.cart.push({
            product_id: item.id,
            product: item,
            quantity: item.quantity
          });
        }
      }
      item.quantity = 1;
      toast.info(`${item.name} added to cart`, this.toastOption);
    },

    openCart() {
      this.cartModal.modal("show");
    },

    closeCart() {
      this.cartModal.modal("hide");
    },

    saveOrder() {
      Swal.fire({
        title: 'Save the Order?',
        text: "Do you wish to save the order?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm'
      }).then((result) => {
        if (result.isConfirmed) {
          
          this.isSubmitting = true;

          const items = this.cart.map((i) => {
            return { quantity: i.quantity, product_id: i.product_id };
          });
          const data = {
            customer: this.customer,
            items: items,
          };

          axios.post(`/orders/create`, data)
            .then((res) => {
              toast.success(`Order has been created`, this.toastOption);
              this.reset();
            })
            .catch((err) => {
              toast.error(`A problem encountered while submitting the order. Please try again.`, this.toastOption);              
              console.log(err);
            })
            .finally(() => {
              this.isSubmitting = false;
            });
        }
      });
    },

    reset() {
      this.$refs["customerSelect"].value = "";
      this.customer = "";
      this.cart = [];
      this.closeCart();        
    }
    
  }
}
</script>
