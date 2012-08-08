#!/usr/bin/make -f

test-unit-guard:
	guard

test-unit:
	phpunit --colors test/unit/*

test-acceptance:
	clear; casperjs test/acceptance/*

test-local-acceptance:
	@echo 'Make sure you have a local webserver running that runs on http://localhost:3000'
	@echo 'You can start one with `php -S 127.0.0.1:3000`'
	casperjs test/acceptance/*

test: test-unit test-acceptance

.PHONY: test
