typedef char byte_t;
typedef float float32_t;
typedef double float64_t;
typedef byte_t wasm_byte_t;
typedef struct wasm_byte_vec_t {
  size_t size;
  wasm_byte_t *data;
} wasm_byte_vec_t;
void wasm_byte_vec_new_empty(/*own*/ wasm_byte_vec_t *out);
void wasm_byte_vec_new_uninitialized(/*own*/ wasm_byte_vec_t *out, size_t);
void wasm_byte_vec_new(/*own*/ wasm_byte_vec_t *out, size_t,
                       /*own*/ wasm_byte_t const[]);
void wasm_byte_vec_delete(/*own*/ wasm_byte_vec_t *);

typedef wasm_byte_vec_t wasm_name_t;

typedef struct wasm_config_t wasm_config_t;

/*own*/ wasm_config_t *wasm_config_new();

typedef struct wasm_engine_t wasm_engine_t;
void wasm_engine_delete(/*own*/ wasm_engine_t *);

/*own*/ wasm_engine_t *wasm_engine_new();
/*own*/ wasm_engine_t *wasm_engine_new_with_config(/*own*/ wasm_config_t *);

typedef struct wasm_store_t wasm_store_t;
void wasm_store_delete(/*own*/ wasm_store_t *);

/*own*/ wasm_store_t *wasm_store_new(wasm_engine_t *);

typedef uint8_t wasm_mutability_t;
enum wasm_mutability_enum {
  WASM_CONST,
  WASM_VAR,
};

typedef struct wasm_limits_t {
  uint32_t min;
  uint32_t max;
} wasm_limits_t;

static const uint32_t wasm_limits_max_default = 0xffffffff;
typedef struct wasm_valtype_t wasm_valtype_t;
void wasm_valtype_delete(/*own*/ wasm_valtype_t *);
typedef struct wasm_valtype_vec_t {
  size_t size;
  wasm_valtype_t **data;
} wasm_valtype_vec_t;
void wasm_valtype_vec_new_empty(/*own*/ wasm_valtype_vec_t *out);
void wasm_valtype_vec_new_uninitialized(/*own*/ wasm_valtype_vec_t *out,
                                        size_t);
void wasm_valtype_vec_new(/*own*/ wasm_valtype_vec_t *out, size_t,
                          /*own*/ wasm_valtype_t *const[]);
void wasm_valtype_vec_delete(/*own*/ wasm_valtype_vec_t *);

typedef uint8_t wasm_valkind_t;
enum wasm_valkind_enum {
  WASM_I32,
  WASM_I64,
  WASM_F32,
  WASM_F64,
  WASM_ANYREF = 128,
  WASM_FUNCREF,
};

/*own*/ wasm_valtype_t *wasm_valtype_new(wasm_valkind_t);

wasm_valkind_t wasm_valtype_kind(const wasm_valtype_t *);

typedef struct wasm_functype_t wasm_functype_t;
void wasm_functype_delete(/*own*/ wasm_functype_t *);
typedef struct wasm_functype_vec_t {
  size_t size;
  wasm_functype_t **data;
} wasm_functype_vec_t;
void wasm_functype_vec_new_empty(/*own*/ wasm_functype_vec_t *out);
void wasm_functype_vec_new_uninitialized(/*own*/ wasm_functype_vec_t *out,
                                         size_t);
void wasm_functype_vec_new(/*own*/ wasm_functype_vec_t *out, size_t,
                           /*own*/ wasm_functype_t *const[]);
void wasm_functype_vec_delete(/*own*/ wasm_functype_vec_t *); /*own*/
wasm_functype_t *wasm_functype_copy(wasm_functype_t *);

/*own*/ wasm_functype_t *wasm_functype_new(
    /*own*/ wasm_valtype_vec_t *params, /*own*/ wasm_valtype_vec_t *results);

const wasm_valtype_vec_t *wasm_functype_params(const wasm_functype_t *);
const wasm_valtype_vec_t *wasm_functype_results(const wasm_functype_t *);

typedef struct wasm_globaltype_t wasm_globaltype_t;
void wasm_globaltype_delete(/*own*/ wasm_globaltype_t *);
typedef struct wasm_globaltype_vec_t {
  size_t size;
  wasm_globaltype_t **data;
} wasm_globaltype_vec_t;
void wasm_globaltype_vec_new_empty(/*own*/ wasm_globaltype_vec_t *out);
void wasm_globaltype_vec_new_uninitialized(/*own*/ wasm_globaltype_vec_t *out,
                                           size_t);
void wasm_globaltype_vec_new(/*own*/ wasm_globaltype_vec_t *out, size_t,
                             /*own*/ wasm_globaltype_t *const[]);
void wasm_globaltype_vec_delete(/*own*/ wasm_globaltype_vec_t *);

/*own*/ wasm_globaltype_t *wasm_globaltype_new(
    /*own*/ wasm_valtype_t *, wasm_mutability_t);

const wasm_valtype_t *wasm_globaltype_content(const wasm_globaltype_t *);
wasm_mutability_t wasm_globaltype_mutability(const wasm_globaltype_t *);

typedef struct wasm_tabletype_t wasm_tabletype_t;
void wasm_tabletype_delete(/*own*/ wasm_tabletype_t *);
typedef struct wasm_tabletype_vec_t {
  size_t size;
  wasm_tabletype_t **data;
} wasm_tabletype_vec_t;
void wasm_tabletype_vec_new_empty(/*own*/ wasm_tabletype_vec_t *out);
void wasm_tabletype_vec_new_uninitialized(/*own*/ wasm_tabletype_vec_t *out,
                                          size_t);
void wasm_tabletype_vec_new(/*own*/ wasm_tabletype_vec_t *out, size_t,
                            /*own*/ wasm_tabletype_t *const[]);
void wasm_tabletype_vec_delete(/*own*/ wasm_tabletype_vec_t *);

/*own*/ wasm_tabletype_t *wasm_tabletype_new(
    /*own*/ wasm_valtype_t *, const wasm_limits_t *);

const wasm_valtype_t *wasm_tabletype_element(const wasm_tabletype_t *);
const wasm_limits_t *wasm_tabletype_limits(const wasm_tabletype_t *);

typedef struct wasm_memorytype_t wasm_memorytype_t;
void wasm_memorytype_delete(/*own*/ wasm_memorytype_t *);
typedef struct wasm_memorytype_vec_t {
  size_t size;
  wasm_memorytype_t **data;
} wasm_memorytype_vec_t;
void wasm_memorytype_vec_new_empty(/*own*/ wasm_memorytype_vec_t *out);
void wasm_memorytype_vec_new_uninitialized(/*own*/ wasm_memorytype_vec_t *out,
                                           size_t);
void wasm_memorytype_vec_new(/*own*/ wasm_memorytype_vec_t *out, size_t,
                             /*own*/ wasm_memorytype_t *const[]);
void wasm_memorytype_vec_delete(/*own*/ wasm_memorytype_vec_t *);

/*own*/ wasm_memorytype_t *wasm_memorytype_new(const wasm_limits_t *);

const wasm_limits_t *wasm_memorytype_limits(const wasm_memorytype_t *);

typedef struct wasm_externtype_t wasm_externtype_t;
void wasm_externtype_delete(/*own*/ wasm_externtype_t *);
typedef struct wasm_externtype_vec_t {
  size_t size;
  wasm_externtype_t **data;
} wasm_externtype_vec_t;
/*own*/ wasm_externtype_t *wasm_externtype_copy(wasm_externtype_t *);

typedef uint8_t wasm_externkind_t;
enum wasm_externkind_enum {
  WASM_EXTERN_FUNC,
  WASM_EXTERN_GLOBAL,
  WASM_EXTERN_TABLE,
  WASM_EXTERN_MEMORY,
};

wasm_externkind_t wasm_externtype_kind(const wasm_externtype_t *);

wasm_externtype_t *wasm_functype_as_externtype(wasm_functype_t *);
wasm_externtype_t *wasm_globaltype_as_externtype(wasm_globaltype_t *);
wasm_externtype_t *wasm_tabletype_as_externtype(wasm_tabletype_t *);
wasm_externtype_t *wasm_memorytype_as_externtype(wasm_memorytype_t *);

wasm_functype_t *wasm_externtype_as_functype(wasm_externtype_t *);
wasm_globaltype_t *wasm_externtype_as_globaltype(wasm_externtype_t *);
wasm_tabletype_t *wasm_externtype_as_tabletype(wasm_externtype_t *);
wasm_memorytype_t *wasm_externtype_as_memorytype(wasm_externtype_t *);

const wasm_externtype_t *
wasm_functype_as_externtype_const(const wasm_functype_t *);
const wasm_externtype_t *
wasm_globaltype_as_externtype_const(const wasm_globaltype_t *);
const wasm_externtype_t *
wasm_tabletype_as_externtype_const(const wasm_tabletype_t *);
const wasm_externtype_t *
wasm_memorytype_as_externtype_const(const wasm_memorytype_t *);

const wasm_functype_t *
wasm_externtype_as_functype_const(const wasm_externtype_t *);
const wasm_globaltype_t *
wasm_externtype_as_globaltype_const(const wasm_externtype_t *);
const wasm_tabletype_t *
wasm_externtype_as_tabletype_const(const wasm_externtype_t *);
const wasm_memorytype_t *
wasm_externtype_as_memorytype_const(const wasm_externtype_t *);

typedef struct wasm_importtype_t wasm_importtype_t;
void wasm_importtype_delete(/*own*/ wasm_importtype_t *);
typedef struct wasm_importtype_vec_t {
  size_t size;
  wasm_importtype_t **data;
} wasm_importtype_vec_t;
void wasm_importtype_vec_new_empty(/*own*/ wasm_importtype_vec_t *out);
void wasm_importtype_vec_new_uninitialized(/*own*/ wasm_importtype_vec_t *out,
                                           size_t);
void wasm_importtype_vec_new(/*own*/ wasm_importtype_vec_t *out, size_t,
                             /*own*/ wasm_importtype_t *const[]);
void wasm_importtype_vec_delete(/*own*/ wasm_importtype_vec_t *);

/*own*/ wasm_importtype_t *wasm_importtype_new(
    /*own*/ wasm_name_t *module, /*own*/ wasm_name_t *name,
    /*own*/ wasm_externtype_t *);

const wasm_name_t *wasm_importtype_module(const wasm_importtype_t *);
const wasm_name_t *wasm_importtype_name(const wasm_importtype_t *);
const wasm_externtype_t *wasm_importtype_type(const wasm_importtype_t *);

typedef struct wasm_exporttype_t wasm_exporttype_t;
void wasm_exporttype_delete(/*own*/ wasm_exporttype_t *);
typedef struct wasm_exporttype_vec_t {
  size_t size;
  wasm_exporttype_t **data;
} wasm_exporttype_vec_t;
void wasm_exporttype_vec_new_empty(/*own*/ wasm_exporttype_vec_t *out);
void wasm_exporttype_vec_new_uninitialized(/*own*/ wasm_exporttype_vec_t *out,
                                           size_t);
void wasm_exporttype_vec_new(/*own*/ wasm_exporttype_vec_t *out, size_t,
                             /*own*/ wasm_exporttype_t *const[]);
void wasm_exporttype_vec_delete(/*own*/ wasm_exporttype_vec_t *);

/*own*/ wasm_exporttype_t *wasm_exporttype_new(
    /*own*/ wasm_name_t *, /*own*/ wasm_externtype_t *);

const wasm_name_t *wasm_exporttype_name(const wasm_exporttype_t *);
const wasm_externtype_t *wasm_exporttype_type(const wasm_exporttype_t *);

struct wasm_ref_t;

typedef struct wasm_val_t {
  wasm_valkind_t kind;
  union {
    int32_t i32;
    int64_t i64;
    float32_t f32;
    float64_t f64;
    struct wasm_ref_t *ref;
  } of;
} wasm_val_t;

void wasm_val_delete(/*own*/ wasm_val_t *v);
void wasm_val_copy(/*own*/ wasm_val_t *out, const wasm_val_t *);

typedef struct wasm_val_vec_t {
  size_t size;
  wasm_val_t *data;
} wasm_val_vec_t;
void wasm_val_vec_new_empty(/*own*/ wasm_val_vec_t *out);
void wasm_val_vec_new_uninitialized(/*own*/ wasm_val_vec_t *out, size_t);
void wasm_val_vec_new(/*own*/ wasm_val_vec_t *out, size_t,
                      /*own*/ wasm_val_t const[]);
void wasm_val_vec_delete(/*own*/ wasm_val_vec_t *);
typedef struct wasm_ref_t wasm_ref_t;

typedef struct wasm_frame_t wasm_frame_t;
void wasm_frame_delete(/*own*/ wasm_frame_t *);
typedef struct wasm_frame_vec_t {
  size_t size;
  wasm_frame_t **data;
} wasm_frame_vec_t;
void wasm_frame_vec_new_empty(/*own*/ wasm_frame_vec_t *out);
void wasm_frame_vec_new_uninitialized(/*own*/ wasm_frame_vec_t *out, size_t);
void wasm_frame_vec_new(/*own*/ wasm_frame_vec_t *out, size_t,
                        /*own*/ wasm_frame_t *const[]);
void wasm_frame_vec_delete(/*own*/ wasm_frame_vec_t *);
/*own*/ wasm_frame_t *wasm_frame_copy(const wasm_frame_t *);

struct wasm_instance_t *wasm_frame_instance(const wasm_frame_t *);
uint32_t wasm_frame_func_index(const wasm_frame_t *);
size_t wasm_frame_func_offset(const wasm_frame_t *);
size_t wasm_frame_module_offset(const wasm_frame_t *);

typedef wasm_name_t wasm_message_t;

typedef struct wasm_trap_t wasm_trap_t;
void wasm_trap_delete(/*own*/ wasm_trap_t *);

/*own*/ wasm_trap_t *wasm_trap_new(wasm_store_t *store, const wasm_message_t *);

void wasm_trap_message(const wasm_trap_t *, /*own*/ wasm_message_t *out);
/*own*/ wasm_frame_t *wasm_trap_origin(const wasm_trap_t *);
void wasm_trap_trace(const wasm_trap_t *, /*own*/ wasm_frame_vec_t *out);

typedef struct wasm_foreign_t wasm_foreign_t;

typedef struct wasm_module_t wasm_module_t;
void wasm_module_delete(/*own*/ wasm_module_t *);
typedef struct wasm_shared_module_t wasm_shared_module_t;

/*own*/ wasm_module_t *wasm_module_new(wasm_store_t *,
                                       const wasm_byte_vec_t *binary);

bool wasm_module_validate(wasm_store_t *, const wasm_byte_vec_t *binary);

void wasm_module_imports(const wasm_module_t *,
                         /*own*/ wasm_importtype_vec_t *out);
void wasm_module_exports(const wasm_module_t *,
                         /*own*/ wasm_exporttype_vec_t *out);

void wasm_module_serialize(const wasm_module_t *, /*own*/ wasm_byte_vec_t *out);
/*own*/ wasm_module_t *wasm_module_deserialize(wasm_store_t *,
                                               const wasm_byte_vec_t *);

typedef struct wasm_func_t wasm_func_t;
void wasm_func_delete(/*own*/ wasm_func_t *);

typedef /*own*/ wasm_trap_t *(*wasm_func_callback_t)(
    const wasm_val_vec_t *args, /*own*/ wasm_val_vec_t *results);
typedef /*own*/ wasm_trap_t *(*wasm_func_callback_with_env_t)(
    void *env, const wasm_val_vec_t *args, wasm_val_vec_t *results);

/*own*/ wasm_func_t *wasm_func_new(wasm_store_t *, const wasm_functype_t *,
                                   wasm_func_callback_t);
/*own*/ wasm_func_t *wasm_func_new_with_env(wasm_store_t *,
                                            const wasm_functype_t *type,
                                            wasm_func_callback_with_env_t,
                                            void *env,
                                            void (*finalizer)(void *));

/*own*/ wasm_functype_t *wasm_func_type(const wasm_func_t *);
size_t wasm_func_param_arity(const wasm_func_t *);
size_t wasm_func_result_arity(const wasm_func_t *);

/*own*/ wasm_trap_t *wasm_func_call(const wasm_func_t *,
                                    const wasm_val_vec_t *args,
                                    wasm_val_vec_t *results);

typedef struct wasm_global_t wasm_global_t;
void wasm_global_delete(/*own*/ wasm_global_t *); /*own*/
wasm_global_t *wasm_global_copy(const wasm_global_t *);
bool wasm_global_same(const wasm_global_t *, const wasm_global_t *);

/*own*/ wasm_global_t *
wasm_global_new(wasm_store_t *, const wasm_globaltype_t *, const wasm_val_t *);

/*own*/ wasm_globaltype_t *wasm_global_type(const wasm_global_t *);

void wasm_global_get(const wasm_global_t *, /*own*/ wasm_val_t *out);
void wasm_global_set(wasm_global_t *, const wasm_val_t *);

typedef struct wasm_table_t wasm_table_t;
void wasm_table_delete(/*own*/ wasm_table_t *); /*own*/
wasm_table_t *wasm_table_copy(const wasm_table_t *);
bool wasm_table_same(const wasm_table_t *, const wasm_table_t *);

typedef uint32_t wasm_table_size_t;

/*own*/ wasm_table_t *wasm_table_new(wasm_store_t *, const wasm_tabletype_t *,
                                     wasm_ref_t *init);

wasm_table_size_t wasm_table_size(const wasm_table_t *);
bool wasm_table_grow(wasm_table_t *, wasm_table_size_t delta, wasm_ref_t *init);

typedef struct wasm_memory_t wasm_memory_t;
void wasm_memory_delete(/*own*/ wasm_memory_t *);
/*own*/ wasm_memory_t *wasm_memory_copy(const wasm_memory_t *);
bool wasm_memory_same(const wasm_memory_t *, const wasm_memory_t *);

typedef uint32_t wasm_memory_pages_t;

static const size_t MEMORY_PAGE_SIZE = 0x10000;

/*own*/ wasm_memory_t *wasm_memory_new(wasm_store_t *,
                                       const wasm_memorytype_t *);

/*own*/ wasm_memorytype_t *wasm_memory_type(const wasm_memory_t *);

byte_t *wasm_memory_data(wasm_memory_t *);
size_t wasm_memory_data_size(const wasm_memory_t *);

wasm_memory_pages_t wasm_memory_size(const wasm_memory_t *);
bool wasm_memory_grow(wasm_memory_t *, wasm_memory_pages_t delta);

typedef struct wasm_extern_t wasm_extern_t;
void wasm_extern_delete(/*own*/ wasm_extern_t *);
typedef struct wasm_extern_vec_t {
  size_t size;
  wasm_extern_t **data;
} wasm_extern_vec_t;
void wasm_extern_vec_new_empty(/*own*/ wasm_extern_vec_t *out);
void wasm_extern_vec_new_uninitialized(/*own*/ wasm_extern_vec_t *out, size_t);
void wasm_extern_vec_new(/*own*/ wasm_extern_vec_t *out, size_t,
                         /*own*/ wasm_extern_t *const[]);
void wasm_extern_vec_delete(/*own*/ wasm_extern_vec_t *);

wasm_externkind_t wasm_extern_kind(const wasm_extern_t *);
/*own*/ wasm_externtype_t *wasm_extern_type(const wasm_extern_t *);

wasm_extern_t *wasm_func_as_extern(wasm_func_t *);
wasm_extern_t *wasm_global_as_extern(wasm_global_t *);
wasm_extern_t *wasm_table_as_extern(wasm_table_t *);
wasm_extern_t *wasm_memory_as_extern(wasm_memory_t *);

wasm_func_t *wasm_extern_as_func(wasm_extern_t *);
wasm_global_t *wasm_extern_as_global(wasm_extern_t *);
wasm_table_t *wasm_extern_as_table(wasm_extern_t *);
wasm_memory_t *wasm_extern_as_memory(wasm_extern_t *);

typedef struct wasm_instance_t wasm_instance_t;
void wasm_instance_delete(/*own*/ wasm_instance_t *);

/*own*/ wasm_instance_t *wasm_instance_new(wasm_store_t *,
                                           const wasm_module_t *,
                                           const wasm_extern_vec_t *imports,
                                           /*own*/ wasm_trap_t **);

void wasm_instance_exports(const wasm_instance_t *,
                           /*own*/ wasm_extern_vec_t *out);

/**
 * Kind of compilers that can be used by the engines.
 *
 * This is a Wasmer-specific type with Wasmer-specific functions for
 * manipulating it.
 */
typedef enum {
  /**
   * Variant to represent the Cranelift compiler. See the
   * [`wasmer_compiler_cranelift`] Rust crate.
   */
  CRANELIFT = 0,
  /**
   * Variant to represent the LLVM compiler. See the
   * [`wasmer_compiler_llvm`] Rust crate.
   */
  LLVM = 1,
  /**
   * Variant to represent the Singlepass compiler. See the
   * [`wasmer_compiler_singlepass`] Rust crate.
   */
  SINGLEPASS = 2,
} wasmer_compiler_t;

/**
 * Kind of engines that can be used by the store.
 *
 * This is a Wasmer-specific type with Wasmer-specific functions for
 * manipulating it.
 */
typedef enum {
  /**
   * Variant to represent the JIT engine. See the
   * [`wasmer_engine_jit`] Rust crate.
   */
  JIT = 0,
  /**
   * Variant to represent the Native engine. See the
   * [`wasmer_engine_native`] Rust crate.
   */
  NATIVE = 1,
  /**
   * Variant to represent the Object File engine. See the
   * [`wasmer_engine_object_file`] Rust crate.
   */
  OBJECT_FILE = 2,
} wasmer_engine_t;

typedef struct wasi_config_t wasi_config_t;

typedef struct wasi_env_t wasi_env_t;

typedef struct wasi_version_t wasi_version_t;

void wasi_config_arg(wasi_config_t *config, const char *arg);

void wasi_config_env(wasi_config_t *config, const char *key, const char *value);

void wasi_config_inherit_stderr(wasi_config_t *config);

void wasi_config_inherit_stdin(wasi_config_t *config);

void wasi_config_inherit_stdout(wasi_config_t *config);

bool wasi_config_mapdir(wasi_config_t *config, const char *alias,
                        const char *dir);

wasi_config_t *wasi_config_new(const char *program_name);

bool wasi_config_preopen_dir(wasi_config_t *config, const char *dir);

void wasi_env_delete(wasi_env_t *_state);

/**
 * Takes ownership over the `wasi_config_t`.
 */
wasi_env_t *wasi_env_new(wasi_config_t *config);

intptr_t wasi_env_read_stderr(wasi_env_t *env, char *buffer,
                              uintptr_t buffer_len);

intptr_t wasi_env_read_stdout(wasi_env_t *env, char *buffer,
                              uintptr_t buffer_len);

/**
 * This function is deprecated. You may safely remove all calls to it and
 * everything will continue to work.
 */
bool wasi_env_set_instance(wasi_env_t *env, const wasm_instance_t *instance);

/**
 * This function is deprecated. You may safely remove all calls to it and
 * everything will continue to work.
 */
void wasi_env_set_memory(wasi_env_t *env, const wasm_memory_t *memory);

/**
 * Takes ownership of `wasi_env_t`.
 */
bool wasi_get_imports(const wasm_store_t *store, const wasm_module_t *module,
                      const wasi_env_t *wasi_env, wasm_extern_vec_t *imports);

wasm_func_t *wasi_get_start_function(wasm_instance_t *instance);

wasi_version_t wasi_get_wasi_version(const wasm_module_t *module);

/**
 * Updates the configuration to specify a particular compiler to use.
 *
 * This is a Wasmer-specific function.
 *
 * # Example
 *
 * ```rust,no_run
 * # use inline_c::assert_c;
 * # fn main() {
 * #    (assert_c! {
 * # #include "tests/wasmer_wasm.h"
 * #
 * int main() {
 *     // Create the configuration.
 *     wasm_config_t* config = wasm_config_new();
 *
 *     // Use the Cranelift compiler.
 *     wasm_config_set_compiler(config, CRANELIFT);
 *
 *     // Create the engine.
 *     wasm_engine_t* engine = wasm_engine_new_with_config(config);
 *
 *     // Check we have an engine!
 *     assert(engine);
 *
 *     // Free everything.
 *     wasm_engine_delete(engine);
 *
 *     return 0;
 * }
 * #    })
 * #    .success();
 * # }
 * ```
 */
void wasm_config_set_compiler(wasm_config_t *config,
                              wasmer_compiler_t compiler);

/**
 * Updates the configuration to specify a particular engine to use.
 *
 * This is a Wasmer-specific function.
 *
 * # Example
 *
 * ```rust,no_run
 * # use inline_c::assert_c;
 * # fn main() {
 * #    (assert_c! {
 * # #include "tests/wasmer_wasm.h"
 * #
 * int main() {
 *     // Create the configuration.
 *     wasm_config_t* config = wasm_config_new();
 *
 *     // Use the JIT engine.
 *     wasm_config_set_engine(config, JIT);
 *
 *     // Create the engine.
 *     wasm_engine_t* engine = wasm_engine_new_with_config(config);
 *
 *     // Check we have an engine!
 *     assert(engine);
 *
 *     // Free everything.
 *     wasm_engine_delete(engine);
 *
 *     return 0;
 * }
 * #    })
 * #    .success();
 * # }
 * ```
 */
void wasm_config_set_engine(wasm_config_t *config, wasmer_engine_t engine);

/**
 * Non-standard Wasmer-specific API to get the module's name,
 * otherwise `out->size` is set to `0` and `out->data` to `NULL`.
 *
 * # Example
 *
 * ```rust
 * # use inline_c::assert_c;
 * # fn main() {
 * #    (assert_c! {
 * # #include "tests/wasmer_wasm.h"
 * #
 * int main() {
 *     // Create the engine and the store.
 *     wasm_engine_t* engine = wasm_engine_new();
 *     wasm_store_t* store = wasm_store_new(engine);
 *
 *     // Create a WebAssembly module from a WAT definition.
 *     wasm_byte_vec_t wat;
 *     wasmer_byte_vec_new_from_string(&wat, "(module $moduleName)");
 *     //                                             ^~~~~~~~~~~ that's the
 * name! wasm_byte_vec_t wasm; wat2wasm(&wat, &wasm);
 *
 *     // Create the module.
 *     wasm_module_t* module = wasm_module_new(store, &wasm);
 *
 *     // Read the module's name.
 *     wasm_name_t name;
 *     wasm_module_name(module, &name);
 *
 *     // It works!
 *     wasmer_assert_name(&name, "moduleName");
 *
 *     // Free everything.
 *     wasm_byte_vec_delete(&name);
 *     wasm_module_delete(module);
 *     wasm_byte_vec_delete(&wasm);
 *     wasm_byte_vec_delete(&wat);
 *     wasm_store_delete(store);
 *     wasm_engine_delete(engine);
 *
 *     return 0;
 * }
 * #    })
 * #    .success();
 * # }
 * ```
 */
void wasm_module_name(const wasm_module_t *module, wasm_name_t *out);

/**
 * Non-standard Wasmer-specific API to set the module's name. The
 * function returns `true` if the name has been updated, `false`
 * otherwise.
 *
 * # Example
 *
 * ```rust
 * # use inline_c::assert_c;
 * # fn main() {
 * #    (assert_c! {
 * # #include "tests/wasmer_wasm.h"
 * #
 * int main() {
 *     // Create the engine and the store.
 *     wasm_engine_t* engine = wasm_engine_new();
 *     wasm_store_t* store = wasm_store_new(engine);
 *
 *     // Create a WebAssembly module from a WAT definition.
 *     wasm_byte_vec_t wat;
 *     wasmer_byte_vec_new_from_string(&wat, "(module)");
 *     wasm_byte_vec_t wasm;
 *     wat2wasm(&wat, &wasm);
 *
 *     // Create the module.
 *     wasm_module_t* module = wasm_module_new(store, &wasm);
 *
 *     // Read the module's name. There is none for the moment.
 *     {
 *         wasm_name_t name;
 *         wasm_module_name(module, &name);
 *
 *         assert(name.size == 0);
 *     }
 *
 *     // So, let's set a new name.
 *     {
 *         wasm_name_t name;
 *         wasmer_byte_vec_new_from_string(&name, "hello");
 *         wasm_module_set_name(module, &name);
 *     }
 *
 *     // And now, let's see the new name.
 *     {
 *         wasm_name_t name;
 *         wasm_module_name(module, &name);
 *
 *         // It works!
 *         wasmer_assert_name(&name, "hello");
 *
 *         wasm_byte_vec_delete(&name);
 *     }
 *
 *     // Free everything.
 *     wasm_module_delete(module);
 *     wasm_byte_vec_delete(&wasm);
 *     wasm_byte_vec_delete(&wat);
 *     wasm_store_delete(store);
 *     wasm_engine_delete(engine);
 *
 *     return 0;
 * }
 * #    })
 * #    .success();
 * # }
 * ```
 */
bool wasm_module_set_name(wasm_module_t *module, const wasm_name_t *name);

/**
 * Gets the length in bytes of the last error if any, zero otherwise.
 *
 * This can be used to dynamically allocate a buffer with the correct number of
 * bytes needed to store a message.
 *
 * # Example
 *
 * See this module's documentation to get a complete example.
 */
int wasmer_last_error_length(void);

/**
 * Gets the last error message if any into the provided buffer
 * `buffer` up to the given `length`.
 *
 * The `length` parameter must be large enough to store the last
 * error message. Ideally, the value should come from
 * [`wasmer_last_error_length`].
 *
 * The function returns the length of the string in bytes, `-1` if an
 * error occurs. Potential errors are:
 *
 *  * The `buffer` is a null pointer,
 *  * The `buffer` is too small to hold the error message.
 *
 * Note: The error message always has a trailing NUL character.
 *
 * Important note: If the provided `buffer` is non-null, once this
 * function has been called, regardless whether it fails or succeeds,
 * the error is cleared.
 *
 * # Example
 *
 * See this module's documentation to get a complete example.
 */
int wasmer_last_error_message(char *buffer, int length);

/**
 * Get the version of the Wasmer C API.
 *
 * The `.h` files already define variables like `WASMER_VERSION*`,
 * but if this file is unreachable, one can use this function to
 * retrieve the full semver version of the Wasmer C API.
 *
 * The returned string is statically allocated. It must _not_ be
 * freed!
 *
 * # Example
 *
 * See the module's documentation.
 */
const char *wasmer_version(void);

/**
 * Get the major version of the Wasmer C API.
 *
 * See [`wasmer_version`] to learn more.
 *
 * # Example
 *
 * ```rust
 * # use inline_c::assert_c;
 * # fn main() {
 * #    (assert_c! {
 * # #include "tests/wasmer_wasm.h"
 * #
 * int main() {
 *     // Get and print the version components.
 *     uint8_t version_major = wasmer_version_major();
 *     uint8_t version_minor = wasmer_version_minor();
 *     uint8_t version_patch = wasmer_version_patch();
 *
 *     printf("%d.%d.%d", version_major, version_minor, version_patch);
 *
 *     return 0;
 * }
 * #    })
 * #    .success()
 * #    .stdout(
 * #         format!(
 * #             "{}.{}.{}",
 * #             env!("CARGO_PKG_VERSION_MAJOR"),
 * #             env!("CARGO_PKG_VERSION_MINOR"),
 * #             env!("CARGO_PKG_VERSION_PATCH")
 * #         )
 * #     );
 * # }
 * ```
 */
uint8_t wasmer_version_major(void);

/**
 * Get the minor version of the Wasmer C API.
 *
 * See [`wasmer_version_major`] to learn more and get an example.
 */
uint8_t wasmer_version_minor(void);

/**
 * Get the patch version of the Wasmer C API.
 *
 * See [`wasmer_version_major`] to learn more and get an example.
 */
uint8_t wasmer_version_patch(void);

/**
 * Get the minor version of the Wasmer C API.
 *
 * See [`wasmer_version_major`] to learn more.
 *
 * The returned string is statically allocated. It must _not_ be
 * freed!
 *
 * # Example
 *
 * ```rust
 * # use inline_c::assert_c;
 * # fn main() {
 * #    (assert_c! {
 * # #include "tests/wasmer_wasm.h"
 * #
 * int main() {
 *     // Get and print the pre version.
 *     const char* version_pre = wasmer_version_pre();
 *     printf("%s", version_pre);
 *
 *     // No need to free the string. It's statically allocated on
 *     // the Rust side.
 *
 *     return 0;
 * }
 * #    })
 * #    .success()
 * #    .stdout(env!("CARGO_PKG_VERSION_PRE"));
 * # }
 * ```
 */
const char *wasmer_version_pre(void);

/**
 * Parses in-memory bytes as either the WAT format, or a binary Wasm
 * module. This is wasmer-specific.
 *
 * In case of failure, `wat2wasm` sets the `out->data = NULL` and `out->size =
 * 0`.
 *
 * # Example
 *
 * See the module's documentation.
 */
void wat2wasm(const wasm_byte_vec_t *wat, wasm_byte_vec_t *out);
