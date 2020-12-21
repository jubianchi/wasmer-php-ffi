.PHONY: clean
clean:
	rm -f package/include/wasmer_wasm_expanded.h package/include/wasm_own.h
	rm -f Cargo.lock composer.lock
	rm -rf vendor target

package/include/wasmer_wasm_expanded.h: package/include/wasmer_wasm.h package/include/wasm_own.h
	sed 's/#include "wasm.h"/#include "wasm_own.h"/' $< | \
		sed '/#include <.*$$/d' | \
		sed '/^\/\//d' | \
		gcc -E -C -I$(@D) - | \
		sed '/^#/d' | \
		clang-format \
	  	> $@

package/include/wasm_own.h: package/include/wasm.h
	sed 's/#define own/#define own #own#/' $< | \
		sed '/#include <.*$$/d' | \
		gcc -E - | \
		sed '/^#.*[0-9]*/d' | \
		sed 's/#own#/\/*own*\//g' | \
		clang-format \
		> $@

composer.lock: composer.json
	composer install --ignore-platform-reqs

Cargo.lock: Cargo.toml
	cargo vendor vendor/cargo

.PHONY: vendor
vendor: composer.lock Cargo.lock

.PHONY: examples
.SILENT: examples
examples: vendor
	set -e; \
	for example in $@/*.php; \
	do \
	  	echo "--------------------------------------------------"; \
	  	echo "Running $$example"; \
	  	echo "--------------------------------------------------"; \
	  	php -n -dmemory_limit=1b $$example; \
	done