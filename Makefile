#!/usr/bin/make -f

test-unit-guard:
	guard

test-unit:
	phpunit --colors test/unit

test-acceptance:
	casperjs test/acceptance/*

test: test-unit test-acceptance

.PHONY: test
