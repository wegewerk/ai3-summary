# Ai3 Summary

**Ai3 Summary** (`ai3_summary`) is the Summary capability of the *Ai3 Suite*.
It provides an assistant to create ContentElements describing the content of a TYPO3 Page.

## Features

- **AI-Generated Summary**: Automatically generate page summary based on page content.
- **Multi-language Support**: Works across different languages supported by your TYPO3 installation and AI3 Suite.

## Requirements

| Dependency | Version |
|---|---|
| TYPO3 CMS | `^13.4.0 \| ^14.0` |
| `wegewerk/ai3_core` | `@dev` |

## Installation

```bash
composer require wegewerk/ai3_summary
```

`wegewerk/ai3_core` is pulled in automatically as a Composer dependency.

## Quick start

1. Set the ZAK-AI credentials as environment variables:

   ```bash
   export ZAKAI_API_KEY=<your-api-key>
   export ZAKAI_SECRET=<your-secret>
   ```

## Configuration

This Extension does not provide any configuration settings. Configure the ZAK-AI credentials via environment variables.
See ai3_core

## Changelog

See [CHANGELOG.md](CHANGELOG.md).
