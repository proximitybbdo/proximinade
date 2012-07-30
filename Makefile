#!/usr/bin/make -f

test-unit-guard:
	guard

test-unit:
	phpunit --colors test/unit/*

test-acceptance:
	php -S 0.0.0.0:7000 | casperjs test/acceptance/*

test: test-unit test-acceptance

.PHONY: test
